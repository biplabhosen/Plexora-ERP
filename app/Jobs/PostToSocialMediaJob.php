<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Services\CampaignService;
use App\Services\SocialPostingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class PostToSocialMediaJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Campaign $campaign,
        public array $context = [],
    ) {
    }

    public function handle(SocialPostingService $socialPostingService, CampaignService $campaignService): void
    {
        try {
            $result = match ($this->campaign->channel) {
                Campaign::CHANNEL_FACEBOOK => $socialPostingService->postToFacebook($this->campaign),
                Campaign::CHANNEL_INSTAGRAM => $socialPostingService->postToInstagram($this->campaign),
                default => [
                    'status' => Campaign::STATUS_FAILED,
                    'message' => 'Unsupported social channel.',
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
