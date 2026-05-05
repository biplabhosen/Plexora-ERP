<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Services\CampaignService;
use App\Services\MarketingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class SendMarketingCampaignJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Campaign $campaign,
        public array $context = [],
    ) {
    }

    public function handle(MarketingService $marketingService, CampaignService $campaignService): void
    {
        try {
            $recipients = $campaignService->resolveRecipients($this->campaign, $this->context);

            $result = match ($this->campaign->channel) {
                Campaign::CHANNEL_EMAIL => $marketingService->sendEmail($this->campaign, $recipients, $this->context),
                Campaign::CHANNEL_SMS => $marketingService->sendSms($this->campaign, $recipients, $this->context),
                default => [
                    'status' => Campaign::STATUS_FAILED,
                    'message' => 'Unsupported marketing channel.',
                ],
            };

            $campaignService->writeLog($this->campaign, $result['status'], $result['message']);
            $campaignService->completeCampaign($this->campaign->fresh(), $result['status']);
        } catch (Throwable $throwable) {
            report($throwable);

            $campaignService->writeLog($this->campaign, Campaign::STATUS_FAILED, $throwable->getMessage());
            $campaignService->completeCampaign($this->campaign->fresh(), Campaign::STATUS_FAILED);
        }
    }
}
