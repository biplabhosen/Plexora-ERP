<?php

namespace App\Services;

use App\Jobs\NotifyAdminJob;
use App\Jobs\NotifySupplierJob;
use App\Jobs\SendCustomerEmailJob;
use App\Models\AutomationRule;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rfq;
use App\Models\WorkflowLog;
use DateInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Throwable;

class AutomationService
{
    public function run(string $event, mixed $payload = null): void
    {
        $rules = AutomationRule::query()
            ->active()
            ->where('event', $event)
            ->orderBy('id')
            ->get();

        $context = $this->buildContext($payload, $event);

        foreach ($rules as $rule) {
            try {
                if (! $this->passesCondition($rule, $payload, $context)) {
                    continue;
                }

                if ($this->shouldSkipDuplicateAction($rule, $context)) {
                    continue;
                }

                $this->executeAction($rule, $context);

                $this->writeLog($rule, $event, WorkflowLogStatus::SUCCESS, [
                    'rule' => $rule->name,
                    'action' => $rule->action,
                    'context' => $context,
                ]);
            } catch (Throwable $throwable) {
                report($throwable);

                $this->writeLog($rule, $event, WorkflowLogStatus::FAILED, [
                    'rule' => $rule->name,
                    'error' => $throwable->getMessage(),
                    'context' => $context,
                ]);
            }
        }
    }

    private function passesCondition(AutomationRule $rule, mixed $payload, array $context): bool
    {
        $condition = trim((string) $rule->condition);

        if ($condition === '') {
            return true;
        }

        if ($condition === 'unresolved_24h') {
            return $this->hasBeenUnresolvedFor24Hours($payload, $context);
        }

        if (preg_match('/^([\w\.]+)\s*(==|=|!=|>=|<=|>|<)\s*(.+)$/', $condition, $matches) !== 1) {
            return false;
        }

        [, $field, $operator, $expected] = $matches;

        $actual = data_get($context, $field, data_get($payload, $field));
        $expected = trim($expected, " \t\n\r\0\x0B'\"");

        return match ($operator) {
            '=', '==' => (string) $actual === $expected,
            '!=' => (string) $actual !== $expected,
            '>' => (float) $actual > (float) $expected,
            '<' => (float) $actual < (float) $expected,
            '>=' => (float) $actual >= (float) $expected,
            '<=' => (float) $actual <= (float) $expected,
        };
    }

    private function hasBeenUnresolvedFor24Hours(mixed $payload, array $context): bool
    {
        if (! $payload instanceof Product) {
            return false;
        }

        if ($payload->stock > $payload->moq) {
            return false;
        }

        $threshold = now()->subDay();
        $fingerprint = $this->contextFingerprint($context);

        $initialLowStockLog = WorkflowLog::query()
            ->where('event', AutomationRule::EVENT_STOCK_LOW)
            ->where('status', WorkflowLogStatus::SUCCESS)
            ->where('message', 'like', '%"action":"notify_supplier"%')
            ->where('message', 'like', "%{$fingerprint}%")
            ->oldest('created_at')
            ->first();

        if (! $initialLowStockLog) {
            return false;
        }

        return $initialLowStockLog->created_at->lte($threshold);
    }

    private function shouldSkipDuplicateAction(AutomationRule $rule, array $context): bool
    {
        $fingerprint = $this->contextFingerprint($context);
        $window = $this->duplicateWindow($rule);

        if (! $window) {
            return false;
        }

        return WorkflowLog::query()
            ->where('automation_rule_id', $rule->id)
            ->where('event', $rule->event)
            ->where('status', WorkflowLogStatus::SUCCESS)
            ->where('message', 'like', '%"action":"'.$rule->action.'"%')
            ->where('message', 'like', "%{$fingerprint}%")
            ->where('created_at', '>=', now()->sub($window))
            ->exists();
    }

    private function duplicateWindow(AutomationRule $rule): ?DateInterval
    {
        if ($rule->event !== AutomationRule::EVENT_STOCK_LOW) {
            return new DateInterval('PT1H');
        }

        return match ($rule->condition) {
            'unresolved_24h' => new DateInterval('PT24H'),
            default => new DateInterval('PT24H'),
        };
    }

    private function executeAction(AutomationRule $rule, array $context): void
    {
        match ($rule->action) {
            AutomationRule::ACTION_SEND_EMAIL => SendCustomerEmailJob::dispatch($context, $rule->target)->onQueue('automation'),
            AutomationRule::ACTION_NOTIFY_SUPPLIER => NotifySupplierJob::dispatch($context, $rule->target)->onQueue('automation'),
            AutomationRule::ACTION_NOTIFY_ADMIN => NotifyAdminJob::dispatch($context, $rule->target)->onQueue('automation'),
            AutomationRule::ACTION_LOG_ONLY => Log::info('Automation log-only rule executed.', ['rule_id' => $rule->id] + $context),
        };
    }

    private function writeLog(?AutomationRule $rule, string $event, string $status, array $message): void
    {
        WorkflowLog::query()->create([
            'automation_rule_id' => $rule?->id,
            'event' => $event,
            'status' => $status,
            'message' => json_encode($message, JSON_UNESCAPED_SLASHES),
        ]);
    }

    private function buildContext(mixed $payload, string $event): array
    {
        $context = [
            'event' => $event,
        ];

        if ($payload instanceof Order) {
            $payload->loadMissing('customer');

            return $context + [
                'order_id' => $payload->id,
                'order_number' => $payload->order_number,
                'customer_id' => $payload->customer_id,
                'customer_name' => $payload->customer?->name,
                'customer_email' => $payload->customer?->email,
                'title' => "Order {$payload->order_number} received",
                'subject' => "Order {$payload->order_number} received",
                'body' => "Your order {$payload->order_number} has been placed successfully and is now in processing.",
                'meta' => [
                    'Order ID' => $payload->id,
                    'Order Number' => $payload->order_number,
                    'Customer' => $payload->customer?->name,
                    'Grand Total' => $payload->grand_total,
                    'Status' => $payload->status,
                ],
            ];
        }

        if ($payload instanceof Rfq) {
            $payload->loadMissing(['buyer', 'supplier.user']);

            return $context + [
                'rfq_id' => $payload->id,
                'rfq_title' => $payload->title,
                'buyer_id' => $payload->buyer_id,
                'buyer_name' => $payload->buyer?->name,
                'buyer_email' => $payload->buyer?->email,
                'supplier_id' => $payload->supplier_id,
                'supplier_name' => $payload->supplier?->company_name,
                'supplier_email' => $payload->supplier?->email ?: $payload->supplier?->user?->email,
                'quantity' => $payload->quantity,
                'title' => 'New RFQ Request',
                'subject' => "New RFQ: {$payload->title}",
                'body' => "A new RFQ titled '{$payload->title}' has been created and is awaiting supplier review.",
                'meta' => [
                    'RFQ ID' => $payload->id,
                    'RFQ Title' => $payload->title,
                    'Buyer' => $payload->buyer?->name,
                    'Supplier' => $payload->supplier?->company_name,
                    'Quantity' => $payload->quantity,
                    'Status' => $payload->status,
                ],
            ];
        }

        if ($payload instanceof Product) {
            $payload->loadMissing('supplier.user');

            return $context + [
                'product_id' => $payload->id,
                'product_name' => $payload->name,
                'stock' => $payload->stock,
                'moq' => $payload->moq,
                'supplier_id' => $payload->supplier_id,
                'supplier_name' => $payload->supplier?->company_name,
                'supplier_email' => $payload->supplier?->email ?: $payload->supplier?->user?->email,
                'detected_at' => Carbon::now()->toDateTimeString(),
                'title' => 'Inventory Warning',
                'subject' => "Low stock alert: {$payload->name}",
                'body' => "{$payload->name} is at {$payload->stock} units, which is at or below the MOQ threshold of {$payload->moq}.",
                'meta' => [
                    'Product ID' => $payload->id,
                    'Product Name' => $payload->name,
                    'Current Stock' => $payload->stock,
                    'MOQ Threshold' => $payload->moq,
                    'Supplier' => $payload->supplier?->company_name,
                    'Detected At' => Carbon::now()->toDateTimeString(),
                ],
            ];
        }

        if ($payload instanceof Model) {
            return $context + [
                'model_type' => $payload::class,
                'model_id' => $payload->getKey(),
            ];
        }

        return $context + [
            'payload' => $payload,
        ];
    }

    private function contextFingerprint(array $context): string
    {
        $keys = ['order_id', 'rfq_id', 'product_id', 'supplier_id', 'customer_id'];
        $fingerprint = collect($keys)
            ->filter(fn (string $key): bool => array_key_exists($key, $context) && $context[$key] !== null)
            ->mapWithKeys(fn (string $key): array => [$key => $context[$key]]);

        return json_encode($fingerprint, JSON_UNESCAPED_SLASHES);
    }
}
