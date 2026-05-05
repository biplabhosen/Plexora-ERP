<?php

namespace App\Http\Controllers;

use App\Http\Requests\Lead\StoreLeadRequest;
use App\Http\Requests\Lead\UpdateLeadRequest;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        return view('leads.index', [
            'leads' => Lead::query()
                ->with('assignedUser:id,name')
                ->status($status)
                ->latest()
                ->paginate(10)
                ->withQueryString(),
            'status' => $status,
            'statuses' => Lead::STATUSES,
        ]);
    }

    public function create(): View
    {
        return view('leads.create', [
            'lead' => new Lead(['status' => Lead::STATUS_NEW]),
            'statuses' => Lead::STATUSES,
            'users' => User::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(StoreLeadRequest $request): RedirectResponse
    {
        Lead::query()->create($request->validated());

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead created successfully.');
    }

    public function edit(Lead $lead): View
    {
        return view('leads.edit', [
            'lead' => $lead,
            'statuses' => Lead::STATUSES,
            'users' => User::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(UpdateLeadRequest $request, Lead $lead): RedirectResponse
    {
        $lead->update($request->validated());

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead updated successfully.');
    }

    public function destroy(Lead $lead): RedirectResponse
    {
        $lead->delete();

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead deleted successfully.');
    }
}
