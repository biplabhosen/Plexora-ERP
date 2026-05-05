<?php

namespace App\Jobs;

use App\Mail\CustomerWorkflowMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCustomerEmailJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public array $context,
        public ?string $target = null
    ) {}

    public function handle(): void
    {
        $recipient = $this->target ?: ($this->context['customer_email'] ?? null);

        if (! $recipient) {
            Log::warning('Automation customer email skipped because no recipient email was resolved.', $this->context);

            return;
        }

        Mail::to($recipient)->send(
            new CustomerWorkflowMail([
                'subject' => $this->context['subject'] ?? 'Order workflow notification',
                'title' => $this->context['title'] ?? ($this->context['subject'] ?? 'Order Update'),
                'body' => $this->context['body'] ?? 'Your workflow event has been processed.',
                'meta' => array_filter($this->context['meta'] ?? [], fn ($value) => $value !== null && $value !== ''),
            ])
        );
    }
}
