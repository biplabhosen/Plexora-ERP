<?php

namespace App\Jobs;

use App\Mail\AdminWorkflowMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyAdminJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public array $context,
        public ?string $target = null
    ) {}

    public function handle(): void
    {
        $recipients = $this->resolveRecipients();

        if ($recipients === []) {
            Log::warning('Automation admin notification skipped because no admin recipient email was resolved.', $this->context);

            return;
        }

        foreach ($recipients as $recipient) {
            Mail::to($recipient)->send(
                new AdminWorkflowMail([
                    'subject' => $this->context['subject'] ?? 'Admin workflow notification',
                    'title' => $this->context['title'] ?? ($this->context['subject'] ?? 'Admin Alert'),
                    'body' => $this->context['body'] ?? 'A workflow automation event requires admin attention.',
                    'meta' => array_filter($this->context['meta'] ?? [], fn ($value) => $value !== null && $value !== ''),
                ])
            );
        }
    }

    private function resolveRecipients(): array
    {
        if ($this->target) {
            return [$this->target];
        }

        return User::query()
            ->whereHas('role', fn ($query) => $query->where('name', 'admin'))
            ->whereNotNull('email')
            ->pluck('email')
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
