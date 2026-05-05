<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Rfq;
use App\Models\SupportTicket;
use App\Models\Supplier;
use App\Models\User;
use App\Models\WorkflowLog;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getMetrics(): array
    {
        return Cache::remember('dashboard.metrics', now()->addMinutes(2), function (): array {
            $today = today();
            $monthStart = now()->startOfMonth();
            $weekStart = CarbonImmutable::today()->subDays(6);
            $revenueStart = CarbonImmutable::today()->subDays(29);

            return [
                'totalOrders' => Order::query()->count(),
                'todayOrders' => Order::query()->whereDate('created_at', $today)->count(),
                'monthlyRevenue' => Order::query()
                    ->whereBetween('created_at', [$monthStart, now()])
                    ->sum('grand_total'),
                'pendingSuppliers' => Supplier::query()->where('status', 'pending')->count(),
                'openRfqs' => Rfq::query()->where('status', 'open')->count(),
                'lowStockProducts' => Product::query()->whereColumn('stock', '<=', 'moq')->count(),
                'automationRunsToday' => WorkflowLog::query()->whereDate('created_at', $today)->count(),
                'totalUsers' => User::query()->count(),
                'totalCustomers' => Customer::query()->count(),
                'openTickets' => SupportTicket::query()->open()->count(),
                'scheduledCampaigns' => Campaign::query()->scheduled()->count(),
                'recentOrders' => Order::query()
                    ->with('customer:id,name')
                    ->latest()
                    ->limit(5)
                    ->get(),
                'recentRfqs' => Rfq::query()
                    ->with([
                        'buyer:id,name',
                        'supplier:id,company_name',
                    ])
                    ->latest()
                    ->limit(5)
                    ->get(),
                'recentLogs' => WorkflowLog::query()
                    ->with('automationRule:id,name')
                    ->latest()
                    ->limit(5)
                    ->get(),
                'recentUsers' => User::query()
                    ->with('role:id,name')
                    ->latest()
                    ->limit(5)
                    ->get(),
                'recentTickets' => SupportTicket::query()
                    ->with(['customer:id,name', 'assignee:id,name'])
                    ->latest()
                    ->limit(5)
                    ->get(),
                'ordersChart' => $this->buildOrdersChart($weekStart),
                'revenueChart' => $this->buildRevenueChart($revenueStart),
                'topProducts' => $this->buildTopProductsChart(),
            ];
        });
    }

    private function buildOrdersChart(CarbonImmutable $startDate): array
    {
        $counts = Order::query()
            ->selectRaw('DATE(created_at) as chart_date, COUNT(*) as aggregate')
            ->whereDate('created_at', '>=', $startDate->toDateString())
            ->groupBy('chart_date')
            ->pluck('aggregate', 'chart_date');

        $period = collect(range(0, 6))
            ->map(fn (int $offset): CarbonImmutable => $startDate->addDays($offset));

        return [
            'labels' => $period->map(fn (CarbonImmutable $date): string => $date->format('M d'))->all(),
            'series' => $period->map(
                fn (CarbonImmutable $date): int => (int) ($counts[$date->toDateString()] ?? 0)
            )->all(),
        ];
    }

    private function buildRevenueChart(CarbonImmutable $startDate): array
    {
        $revenue = Order::query()
            ->selectRaw('DATE(created_at) as chart_date, SUM(grand_total) as aggregate')
            ->whereDate('created_at', '>=', $startDate->toDateString())
            ->groupBy('chart_date')
            ->pluck('aggregate', 'chart_date');

        $period = collect(range(0, 29))
            ->map(fn (int $offset): CarbonImmutable => $startDate->addDays($offset));

        return [
            'labels' => $period->map(fn (CarbonImmutable $date): string => $date->format('M d'))->all(),
            'series' => $period->map(
                fn (CarbonImmutable $date): float => round((float) ($revenue[$date->toDateString()] ?? 0), 2)
            )->all(),
        ];
    }

    private function buildTopProductsChart(): array
    {
        $topProducts = OrderItem::query()
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select(
                'order_items.product_id',
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_quantity')
            )
            ->groupBy('order_items.product_id', 'products.name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        return [
            'labels' => $topProducts->pluck('name')->all(),
            'series' => $topProducts->pluck('total_quantity')->map(fn ($quantity): int => (int) $quantity)->all(),
        ];
    }
}
