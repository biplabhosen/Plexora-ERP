<?php

namespace App\Http\Controllers;

use App\Http\Requests\Campaign\StoreCampaignRequest;
use App\Http\Requests\Campaign\UpdateCampaignRequest;
use App\Models\Campaign;
use App\Models\MessageTemplate;
use App\Models\SocialAccount;
use App\Services\CampaignService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CampaignController extends Controller
{
    public function __construct(
        private readonly CampaignService $campaignService,
    ) {
    }

    public function index(Request $request): View
    {
        $type = $request->string('type')->toString() ?: null;

        return view('campaigns.index', [
            'campaigns' => Campaign::query()
                ->with('creator')
                ->withCount('logs')
                ->forType($type)
                ->latest()
                ->paginate(12)
                ->withQueryString(),
            'type' => $type,
            'socialAccounts' => SocialAccount::query()->orderBy('platform')->orderBy('account_name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('campaigns.create', $this->formData(new Campaign([
            'status' => Campaign::STATUS_DRAFT,
            'is_active' => true,
        ])));
    }

    public function store(StoreCampaignRequest $request): RedirectResponse
    {
        $campaign = $this->campaignService->createCampaign(
            $request->validated(),
            $request->file('media'),
            $request->user(),
        );

        return redirect()
            ->route('campaigns.show', $campaign)
            ->with('success', 'Campaign created successfully.');
    }

    public function show(Campaign $campaign): View
    {
        $campaign->load([
            'creator',
            'logs' => fn ($query) => $query->latest()->limit(25),
        ]);

        $engagementPlaceholder = [
            'likes' => $campaign->logs->where('status', Campaign::STATUS_SENT)->count() * 12,
            'comments' => $campaign->logs->where('status', Campaign::STATUS_SENT)->count() * 3,
        ];

        return view('campaigns.show', [
            'campaign' => $campaign,
            'engagementPlaceholder' => $engagementPlaceholder,
        ]);
    }

    public function edit(Campaign $campaign): View
    {
        return view('campaigns.edit', $this->formData($campaign) + [
            'deleteAction' => route('campaigns.destroy', $campaign),
        ]);
    }

    public function update(UpdateCampaignRequest $request, Campaign $campaign): RedirectResponse
    {
        $campaign = $this->campaignService->updateCampaign(
            $campaign,
            $request->validated(),
            $request->file('media'),
        );

        return redirect()
            ->route('campaigns.show', $campaign)
            ->with('success', 'Campaign updated successfully.');
    }

    public function destroy(Campaign $campaign): RedirectResponse
    {
        $campaign->delete();

        return redirect()
            ->route('campaigns.index')
            ->with('success', 'Campaign deleted successfully.');
    }

    public function run(Campaign $campaign): RedirectResponse
    {
        $this->campaignService->runCampaign($campaign);

        return redirect()
            ->route('campaigns.show', $campaign)
            ->with('success', 'Campaign has been queued for processing.');
    }

    private function formData(Campaign $campaign): array
    {
        return [
            'campaign' => $campaign,
            'types' => Campaign::types(),
            'channels' => Campaign::channels(),
            'statuses' => Campaign::statuses(),
            'triggerEvents' => Campaign::triggerEvents(),
            'templates' => MessageTemplate::query()->orderBy('name')->get(),
        ];
    }
}
