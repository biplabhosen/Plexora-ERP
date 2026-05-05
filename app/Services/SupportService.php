<?php

namespace App\Services;

use App\Events\SupportTicketCreated;
use App\Jobs\NotifySupplierJob;
use App\Jobs\SendSupportAutoReplyJob;
use App\Models\Customer;
use App\Models\Order;
use App\Models\SupportReply;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SupportService
{
    public function createTicket(array $data, User $user): SupportTicket
    {
        return DB::transaction(function () use ($data, $user): SupportTicket {
            $order = $this->resolveOrder($data['order_id'] ?? null, $user);
            $supplierId = $data['supplier_id'] ?? $order?->items->first()?->product?->supplier_id;
            $customerId = $this->resolveCustomerId($user, $order);

            $ticket = SupportTicket::query()->create([
                'customer_id' => $customerId,
                'order_id' => $order?->id,
                'supplier_id' => $supplierId,
                'subject' => $data['subject'],
                'message' => $data['message'],
                'category' => $data['category'],
                'priority' => $data['priority'],
                'status' => SupportTicket::STATUS_OPEN,
                'assigned_to' => null,
            ]);

            event(new SupportTicketCreated($ticket->load(['customer', 'order.customer', 'supplier']), $user));

            return $ticket;
        });
    }

    public function autoReply(SupportTicket $ticket): void
    {
        SendSupportAutoReplyJob::dispatch($ticket)->onQueue('support');
    }

    public function notifySupplier(SupportTicket $ticket): void
    {
        NotifySupplierJob::dispatch([
            'type' => 'support_ticket',
            'support_ticket_id' => $ticket->id,
            'supplier_id' => $ticket->supplier_id,
            'subject' => $ticket->subject,
            'category' => $ticket->category,
        ])->onQueue('support');
    }

    public function changeStatus(SupportTicket $ticket, string $status, ?User $user = null): SupportTicket
    {
        $ticket->update([
            'status' => $status,
            'assigned_to' => $ticket->assigned_to ?? $user?->id,
        ]);

        return $ticket->fresh(['customer', 'supplier', 'assignee']);
    }

    public function createReply(SupportTicket $ticket, User $user, string $message): SupportReply
    {
        return $ticket->replies()->create([
            'user_id' => $user->id,
            'message' => $message,
            'is_system' => false,
        ]);
    }

    public function shouldNotifySupplier(SupportTicket $ticket): bool
    {
        return $ticket->category === SupportTicket::CATEGORY_SUPPLIER || $ticket->supplier_id !== null;
    }

    private function resolveOrder(?int $orderId, User $user): ?Order
    {
        if (! $orderId) {
            return null;
        }

        $order = Order::query()
            ->with(['customer', 'items.product'])
            ->findOrFail($orderId);

        if (! $user->hasRole('admin') && ! $user->hasRole('support_agent')) {
            $ownsOrder = $order->customer?->user_id === $user->id;

            throw_if(! $ownsOrder, ValidationException::withMessages([
                'order_id' => 'You can only open tickets for your own orders.',
            ]));
        }

        return $order;
    }

    private function resolveCustomerId(User $user, ?Order $order): ?int
    {
        if ($order?->customer_id) {
            return $order->customer_id;
        }

        if ($user->hasRole('admin') || $user->hasRole('support_agent') || $user->hasRole('supplier')) {
            return null;
        }

        return Customer::query()
            ->where('user_id', $user->id)
            ->value('id');
    }
}
