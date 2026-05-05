<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Services\CampaignService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RunScheduledCampaignJob implements ShouldQueue
{
    use Queueable;

    public function handle(CampaignService $campaignService): void
    {
        Campaign::query()
            ->active()
            ->due()
            ->orderBy('scheduled_at')
            ->chunkById(50, function ($campaigns) use ($campaignService): void {
                foreach ($campaigns as $campaign) {
                    $campaignService->runCampaign($campaign);
                }
            });
    }
}
