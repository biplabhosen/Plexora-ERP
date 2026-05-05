<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\BuyerDashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BuyerDashboardController extends Controller
{
    public function __construct(
        private readonly BuyerDashboardService $dashboardService,
    ) {
    }

    public function index(Request $request): View
    {
        return view('dashboard.buyer', [
            'metrics' => $this->dashboardService->getMetrics($request->user()),
        ]);
    }
}
