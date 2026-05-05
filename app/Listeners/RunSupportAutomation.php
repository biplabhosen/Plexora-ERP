<?php

namespace App\Listeners;

use App\Events\OrderConfirmed;
use App\Events\SupportTicketCreated;
use App\Models\WorkflowLog;
use App\Services\SupportService;
use App\Services\WorkflowLogStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class RunSupportAutomation implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly SupportService $supportService,
    ) {
    }

    public function handle(SupportTicketCreated|OrderConfirmed $event): void
    {
        if ($event instanceof SupportTicketCreated) {
            $this->supportService->autoReply($event->ticket);

            if ($this->supportService->shouldNotifySupplier($event->ticket)) {
                $this->supportService->notifySupplier($event->ticket);
            }

            return;
        }

        $event->order->loadMissing('customer');

        Log::info('Order confirmation automation triggered.', [
            'order_id' => $event->order->id,
            'order_number' => $event->order->order_number,
            'customer_id' => $event->order->customer_id,
        ]);

        Log::info('Order confirmation email placeholder sent.', [
            'order_id' => $event->order->id,
            'customer_email' => $event->order->customer?->email,
        ]);

        Log::info('Order confirmation SMS placeholder sent.', [
            'order_id' => $event->order->id,
            'customer_phone' => $event->order->customer?->phone,
        ]);

        WorkflowLog::query()->create([
            'automation_rule_id' => null,
            'event' => 'order_confirmed',
            'status' => WorkflowLogStatus::SUCCESS,
            'message' => json_encode([
                'order_id' => $event->order->id,
                'order_number' => $event->order->order_number,
                'action' => 'confirmation_placeholders_sent',
            ], JSON_UNESCAPED_SLASHES),
        ]);
    }
}
