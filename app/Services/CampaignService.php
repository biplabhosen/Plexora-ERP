<?php

namespace App\Services;

use App\Jobs\PostToSocialMediaJob;
use App\Jobs\SendMarketingCampaignJob;
use App\Models\Campaign;
use App\Models\CampaignLog;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Rfq;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class CampaignService
{
    public function createCampaign(array $data, ?UploadedFile $media = null, ?User $user = null): Campaign
    {
        if ($media) {
            $data['media_path'] = $media->store('campaign-media', 'public');
        }

        $data['is_active'] = (bool) ($data['is_active'] ?? true);
        $data['created_by'] = $user?->id;

        $campaign = Campaign::query()->create($data);

        if ($campaign->status === Campaign::STATUS_SCHEDULED) {
            $this->scheduleCampaign($campaign);
        }

        return $campaign;
    }

    public function updateCampaign(Campaign $campaign, array $data, ?UploadedFile $media = null): Campaign
    {
        if ($media) {
            if ($campaign->media_path) {
                Storage::disk('public')->delete($campaign->media_path);
            }

            $data['media_path'] = $media->store('campaign-media', 'public');
        }

        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $campaign->update($data);

        if ($campaign->status === Campaign::STATUS_SCHEDULED) {
            $this->scheduleCampaign($campaign);
        }

        return $campaign->fresh(['creator']);
    }

    public function scheduleCampaign(Campaign $campaign): Campaign
    {
        $campaign->forceFill([
            'status' => Campaign::STATUS_SCHEDULED,
            'is_active' => true,
        ])->save();

        $this->dispatchTriggeredCampaigns(
            Campaign::TRIGGER_CAMPAIGN_SCHEDULED,
            $campaign,
            $campaign->id,
        );

        return $campaign->fresh();
    }

    public function runCampaign(Campaign $campaign, array $context = []): void
    {
        $campaign->forceFill([
            'status' => Campaign::STATUS_PROCESSING,
        ])->save();

        if (in_array($campaign->channel, [Campaign::CHANNEL_EMAIL, Campaign::CHANNEL_SMS], true)) {
            SendMarketingCampaignJob::dispatch($campaign, $context)
                ->onQueue('campaigns');

            return;
        }

        PostToSocialMediaJob::dispatch($campaign, $context)
            ->onQueue('campaigns');
    }

    public function dispatchTriggeredCampaigns(string $event, mixed $payload = null, ?int $exceptCampaignId = null): int
    {
        $campaigns = Campaign::query()
            ->active()
            ->where('trigger_event', $event)
            ->when($exceptCampaignId, fn ($query) => $query->whereKeyNot($exceptCampaignId))
            ->whereIn('status', [
                Campaign::STATUS_SCHEDULED,
                Campaign::STATUS_SENT,
                Campaign::STATUS_FAILED,
            ])
            ->orderBy('id')
            ->get();

        $context = $this->buildTriggerContext($event, $payload);

        foreach ($campaigns as $campaign) {
            $this->runCampaign($campaign, $context);
        }

        return $campaigns->count();
    }

    public function resolveRecipients(Campaign $campaign, array $context = []): Collection
    {
        $triggerRecipient = collect([
            [
                'name' => $context['customer_name'] ?? $context['name'] ?? $context['buyer_name'] ?? null,
                'email' => $context['customer_email'] ?? $context['email'] ?? $context['buyer_email'] ?? null,
                'phone' => $context['customer_phone'] ?? $context['phone'] ?? null,
            ],
        ])->filter(fn (array $recipient): bool => filled($recipient['email']) || filled($recipient['phone']));

        if ($triggerRecipient->isNotEmpty()) {
            return $triggerRecipient->values();
        }

        return match ($campaign->audience) {
            'event_customer' => collect(),
            'all_customers' => Customer::query()
                ->orderBy('name')
                ->get(['name', 'email', 'phone'])
                ->map(fn (Customer $customer): array => [
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                ]),
            'recent_customers' => Customer::query()
                ->where('created_at', '>=', now()->subDays(30))
                ->orderByDesc('created_at')
                ->get(['name', 'email', 'phone'])
                ->map(fn (Customer $customer): array => [
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                ]),
            default => collect(preg_split('/[\r\n,]+/', (string) $campaign->audience))
                ->map(fn (?string $value): string => trim((string) $value))
                ->filter()
                ->map(fn (string $value): array => [
                    'name' => null,
                    'email' => $campaign->channel === Campaign::CHANNEL_EMAIL ? $value : null,
                    'phone' => $campaign->channel === Campaign::CHANNEL_SMS ? $value : null,
                ]),
        };
    }

    public function writeLog(Campaign $campaign, string $status, string $message): CampaignLog
    {
        return $campaign->logs()->create([
            'channel' => $campaign->channel,
            'status' => $status,
            'message' => $message,
            'executed_at' => now(),
        ]);
    }

    public function completeCampaign(Campaign $campaign, string $status): void
    {
        $campaign->forceFill([
            'status' => $status,
        ])->save();
    }

    public function buildTriggerContext(string $event, mixed $payload = null): array
    {
        $context = ['event' => $event];

        if ($payload instanceof User) {
            $payload->loadMissing('customer');

            return $context + [
                'user_id' => $payload->id,
                'name' => $payload->name,
                'email' => $payload->email,
                'phone' => $payload->customer?->phone,
                'customer_name' => $payload->customer?->name ?? $payload->name,
                'customer_email' => $payload->customer?->email ?? $payload->email,
                'customer_phone' => $payload->customer?->phone,
            ];
        }

        if ($payload instanceof Order) {
            $payload->loadMissing('customer');

            return $context + [
                'order_id' => $payload->id,
                'order_number' => $payload->order_number,
                'customer_id' => $payload->customer_id,
                'customer_name' => $payload->customer?->name,
                'customer_email' => $payload->customer?->email,
                'customer_phone' => $payload->customer?->phone,
            ];
        }

        if ($payload instanceof Rfq) {
            $payload->loadMissing('buyer.customer');

            return $context + [
                'rfq_id' => $payload->id,
                'rfq_title' => $payload->title,
                'buyer_id' => $payload->buyer_id,
                'buyer_name' => $payload->buyer?->name,
                'buyer_email' => $payload->buyer?->email,
                'customer_name' => $payload->buyer?->customer?->name ?? $payload->buyer?->name,
                'customer_email' => $payload->buyer?->customer?->email ?? $payload->buyer?->email,
                'customer_phone' => $payload->buyer?->customer?->phone,
            ];
        }

        if ($payload instanceof Campaign) {
            return $context + [
                'campaign_id' => $payload->id,
                'campaign_name' => $payload->name,
                'campaign_channel' => $payload->channel,
            ];
        }

        return $context;
    }
}
