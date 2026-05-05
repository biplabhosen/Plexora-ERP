<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ModuleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModuleController extends Controller
{
    public function __construct(
        private readonly ModuleService $moduleService,
    ) {
    }

    public function index(): View
    {
        return view('admin.modules.index', [
            'modules' => $this->moduleService->all(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->moduleService->update(
            collect($this->moduleService->all())
                ->mapWithKeys(fn (array $module): array => [
                    $module['key'] => $request->boolean("modules.{$module['key']}"),
                ])
                ->all()
        );

        return redirect()
            ->route('admin.modules.index')
            ->with('success', 'Module settings updated successfully.');
    }
}
