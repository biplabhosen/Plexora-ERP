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
        $enabledTypes = collect(Campaign::types())
            ->filter(fn (string $type): bool => module_enabled($type))
            ->values();

        abort_if($enabledTypes->isEmpty(), 403, 'Module disabled');

        $type = $request->string('type')->toString() ?: null;

        if ($type) {
            abort_unless(module_enabled($type), 403, 'Module disabled');
        }

        return view('campaigns.index', [
            'campaigns' => Campaign::query()
                ->with('creator')
                ->withCount('logs')
                ->when(
                    $type,
                    fn ($query) => $query->forType($type),
                    fn ($query) => $query->whereIn('type', $enabledTypes->all())
                )
                ->latest()
                ->paginate(12)
                ->withQueryString(),
            'type' => $type,
            'socialAccounts' => SocialAccount::query()->orderBy('platform')->orderBy('account_name')->get(),
        ]);
    }

    public function create(): View
    {
        $defaultType = request()->string('type')->toString()
            ?: (module_enabled(Campaign::TYPE_MARKETING) ? Campaign::TYPE_MARKETING : Campaign::TYPE_SOCIAL);

        abort_unless(module_enabled($defaultType), 403, 'Module disabled');

        return view('campaigns.create', $this->formData(new Campaign([
            'type' => $defaultType,
            'status' => Campaign::STATUS_DRAFT,
            'is_active' => true,
        ])));
    }

    public function store(StoreCampaignRequest $request): RedirectResponse
    {
        abort_unless(module_enabled($request->validated('type')), 403, 'Module disabled');

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
        abort_unless(module_enabled($campaign->type), 403, 'Module disabled');

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
        abort_unless(module_enabled($campaign->type), 403, 'Module disabled');

        return view('campaigns.edit', $this->formData($campaign) + [
            'deleteAction' => route('campaigns.destroy', $campaign),
        ]);
    }

    public function update(UpdateCampaignRequest $request, Campaign $campaign): RedirectResponse
    {
        abort_unless(module_enabled($campaign->type), 403, 'Module disabled');
        abort_unless(module_enabled($request->validated('type')), 403, 'Module disabled');

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
        abort_unless(module_enabled($campaign->type), 403, 'Module disabled');

        $campaign->delete();

        return redirect()
            ->route('campaigns.index')
            ->with('success', 'Campaign deleted successfully.');
    }

    public function run(Campaign $campaign): RedirectResponse
    {
        abort_unless(module_enabled($campaign->type), 403, 'Module disabled');

        $this->campaignService->runCampaign($campaign);

        return redirect()
            ->route('campaigns.show', $campaign)
            ->with('success', 'Campaign has been queued for processing.');
    }

    private function formData(Campaign $campaign): array
    {
        return [
            'campaign' => $campaign,
            'types' => collect(Campaign::types())
                ->filter(fn (string $type): bool => module_enabled($type))
                ->values()
                ->all(),
            'channels' => Campaign::channels(),
            'statuses' => Campaign::statuses(),
            'triggerEvents' => Campaign::triggerEvents(),
            'templates' => MessageTemplate::query()->orderBy('name')->get(),
        ];
    }
}
