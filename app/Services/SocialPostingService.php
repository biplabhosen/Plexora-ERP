<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\SocialAccount;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class SocialPostingService
{
    public function postToFacebook(Campaign $campaign): array
    {
        $accounts = $this->accountsFor(SocialAccount::PLATFORM_FACEBOOK);

        return $this->mockPost($campaign, 'Facebook', $accounts);
    }

    public function postToInstagram(Campaign $campaign): array
    {
        $accounts = $this->accountsFor(SocialAccount::PLATFORM_INSTAGRAM);

        return $this->mockPost($campaign, 'Instagram', $accounts);
    }

    private function accountsFor(string $platform): Collection
    {
        return SocialAccount::query()
            ->active()
            ->where('platform', $platform)
            ->orderBy('account_name')
            ->get();
    }

    private function mockPost(Campaign $campaign, string $platformLabel, Collection $accounts): array
    {
        Log::info('Mock social campaign published.', [
            'campaign_id' => $campaign->id,
            'platform' => $platformLabel,
            'accounts' => $accounts->pluck('account_name')->all(),
            'media_path' => $campaign->media_path,
        ]);

        $accountCount = $accounts->count();

        return [
            'status' => Campaign::STATUS_SENT,
            'message' => $accountCount > 0
                ? "Mock {$platformLabel} post published to {$accountCount} account(s)."
                : "Mock {$platformLabel} post published without a linked account placeholder.",
        ];
    }
}
