<?php

namespace App\Services;

use App\Models\Campaign;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class MarketingService
{
    public function sendEmail(Campaign $campaign, Collection $recipients, array $context = []): array
    {
        $emails = $recipients->pluck('email')->filter()->unique()->values();

        if ($emails->isEmpty()) {
            return [
                'status' => Campaign::STATUS_FAILED,
                'message' => 'No email recipients could be resolved for this campaign.',
            ];
        }

        Log::info('Mock marketing email campaign dispatched.', [
            'campaign_id' => $campaign->id,
            'subject' => $campaign->subject,
            'recipients' => $emails->all(),
            'context' => $context,
        ]);

        return [
            'status' => Campaign::STATUS_SENT,
            'message' => 'Mock email sent to '.count($emails).' recipient(s).',
        ];
    }

    public function sendSms(Campaign $campaign, Collection $recipients, array $context = []): array
    {
        $phones = $recipients->pluck('phone')->filter()->unique()->values();

        if ($phones->isEmpty()) {
            return [
                'status' => Campaign::STATUS_FAILED,
                'message' => 'No SMS recipients could be resolved for this campaign.',
            ];
        }

        Log::info('Mock marketing SMS campaign dispatched.', [
            'campaign_id' => $campaign->id,
            'recipients' => $phones->all(),
            'context' => $context,
        ]);

        return [
            'status' => Campaign::STATUS_SENT,
            'message' => 'Mock SMS sent to '.count($phones).' recipient(s).',
        ];
    }
}
