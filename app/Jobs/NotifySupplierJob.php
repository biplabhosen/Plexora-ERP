<?php

namespace App\Jobs;

use App\Mail\SupplierWorkflowMail;
use App\Models\SupportTicket;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifySupplierJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public array $context,
        public ?string $target = null
    ) {
    }

    public function handle(): void
    {
        if (($this->context['type'] ?? null) === 'support_ticket') {
            $ticket = SupportTicket::query()->find($this->context['support_ticket_id'] ?? 0);

            if (! $ticket) {
                Log::warning('Support supplier notification skipped because the ticket was not found.', $this->context);

                return;
            }

            Log::info('Supplier notified for ticket #'.$ticket->id, [
                'ticket_id' => $ticket->id,
                'supplier_id' => $ticket->supplier_id,
                'category' => $ticket->category,
            ]);

            return;
        }

        $recipient = $this->target ?: ($this->context['supplier_email'] ?? null);

        if (! $recipient) {
            Log::warning('Automation supplier notification skipped because no recipient email was resolved.', $this->context);

            return;
        }

        Mail::to($recipient)->send(
            new SupplierWorkflowMail([
                'subject' => $this->context['subject'] ?? 'Supplier workflow notification',
                'title' => $this->context['title'] ?? ($this->context['subject'] ?? 'Supplier Alert'),
                'body' => $this->context['body'] ?? 'A workflow automation event requires your attention.',
                'meta' => array_filter($this->context['meta'] ?? [], fn ($value) => $value !== null && $value !== ''),
            ])
        );
    }
}
