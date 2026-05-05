<?php

namespace App\Http\Controllers;

use App\Http\Requests\Template\StoreTemplateRequest;
use App\Models\MessageTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TemplateController extends Controller
{
    public function index(): View
    {
        return view('templates.index', [
            'templates' => MessageTemplate::query()
                ->latest()
                ->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('templates.create', [
            'template' => new MessageTemplate(),
            'channels' => MessageTemplate::channels(),
        ]);
    }

    public function store(StoreTemplateRequest $request): RedirectResponse
    {
        MessageTemplate::query()->create($request->validated());

        return redirect()
            ->route('templates.index')
            ->with('success', 'Template created successfully.');
    }

    public function edit(MessageTemplate $template): View
    {
        return view('templates.edit', [
            'template' => $template,
            'channels' => MessageTemplate::channels(),
        ]);
    }

    public function update(StoreTemplateRequest $request, MessageTemplate $template): RedirectResponse
    {
        $template->update($request->validated());

        return redirect()
            ->route('templates.index')
            ->with('success', 'Template updated successfully.');
    }

    public function destroy(MessageTemplate $template): RedirectResponse
    {
        $template->delete();

        return redirect()
            ->route('templates.index')
            ->with('success', 'Template deleted successfully.');
    }
}
