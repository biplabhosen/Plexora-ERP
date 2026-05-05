<?php

namespace App\Http\Controllers;

use App\Http\Requests\Automation\StoreAutomationRuleRequest;
use App\Models\AutomationRule;
use App\Models\WorkflowLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AutomationRuleController extends Controller
{
    public function index(): View
    {
        return view('automation.index', [
            'rules' => AutomationRule::query()->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('automation.create', $this->formData(new AutomationRule()));
    }

    public function store(StoreAutomationRuleRequest $request): RedirectResponse
    {
        AutomationRule::query()->create($this->validatedPayload($request));

        return redirect()
            ->route('automation.index')
            ->with('success', 'Automation rule created successfully.');
    }

    public function edit(AutomationRule $automation): View
    {
        return view('automation.edit', $this->formData($automation));
    }

    public function update(StoreAutomationRuleRequest $request, AutomationRule $automation): RedirectResponse
    {
        $automation->update($this->validatedPayload($request));

        return redirect()
            ->route('automation.index')
            ->with('success', 'Automation rule updated successfully.');
    }

    public function destroy(AutomationRule $automation): RedirectResponse
    {
        $automation->delete();

        return redirect()
            ->route('automation.index')
            ->with('success', 'Automation rule deleted successfully.');
    }

    public function logs(): View
    {
        return view('automation.logs', [
            'logs' => WorkflowLog::query()
                ->with('automationRule')
                ->latest()
                ->paginate(20),
        ]);
    }

    private function formData(AutomationRule $rule): array
    {
        return [
            'rule' => $rule,
            'events' => [
                AutomationRule::EVENT_ORDER_PLACED => 'Order Placed',
                AutomationRule::EVENT_RFQ_CREATED => 'RFQ Created',
                AutomationRule::EVENT_STOCK_LOW => 'Stock Low',
            ],
            'actions' => [
                AutomationRule::ACTION_SEND_EMAIL => 'Send Email',
                AutomationRule::ACTION_NOTIFY_SUPPLIER => 'Notify Supplier',
                AutomationRule::ACTION_NOTIFY_ADMIN => 'Notify Admin',
                AutomationRule::ACTION_LOG_ONLY => 'Log Only',
            ],
        ];
    }

    private function validatedPayload(StoreAutomationRuleRequest $request): array
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
