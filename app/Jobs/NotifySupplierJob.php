<?php

namespace App\Jobs;

use App\Mail\SupplierWorkflowMail;
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
    ) {}

    public function handle(): void
    {
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
