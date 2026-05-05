<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\AdminDashboardService;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __construct(
        private readonly AdminDashboardService $dashboardService,
    ) {
    }

    public function index(): View
    {
        return view('dashboard.admin', [
            'metrics' => $this->dashboardService->getMetrics(),
        ]);
    }
}
