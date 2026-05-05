<?php

namespace App\Jobs;

use App\Models\SupportTicket;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendSupportAutoReplyJob implements ShouldQueue
{
    use Queueable;

    private const MESSAGE = 'Thank you. Your request has been received. Our team will contact you soon.';

    public function __construct(
        public SupportTicket $ticket,
    ) {
    }

    public function handle(): void
    {
        $this->ticket->replies()->firstOrCreate(
            [
                'message' => self::MESSAGE,
                'is_system' => true,
            ],
            [
                'user_id' => null,
            ]
        );
    }
}
