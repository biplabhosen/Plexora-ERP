<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\SupplierDashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierDashboardController extends Controller
{
    public function __construct(
        private readonly SupplierDashboardService $dashboardService,
    ) {
    }

    public function index(Request $request): View
    {
        return view('dashboard.supplier', [
            'metrics' => $this->dashboardService->getMetrics($request->user()),
        ]);
    }
}
