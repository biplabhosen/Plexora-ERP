<?php

namespace App\Services\Dashboard;

use App\Models\Order;
use App\Models\Rfq;
use App\Models\SupportTicket;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;

class BuyerDashboardService
{
    public function getMetrics(User $user): array
    {
        $customerId = $user->customer?->id;
        $ordersQuery = Order::query()->whereHas('customer', fn (Builder $query) => $query->where('user_id', $user->id));
        $rfqsQuery = Rfq::query()->where('buyer_id', $user->id);
        $ticketsQuery = SupportTicket::query()->whereHas('customer', fn (Builder $query) => $query->where('user_id', $user->id));

        return [
            'myOrders' => (clone $ordersQuery)->count(),
            'pendingOrders' => (clone $ordersQuery)->where('status', 'pending')->count(),
            'completedOrders' => (clone $ordersQuery)->where('status', 'confirmed')->count(),
            'myRfqs' => (clone $rfqsQuery)->count(),
            'openTickets' => (clone $ticketsQuery)->open()->count(),
            'totalSpend' => (float) (clone $ordersQuery)->sum('grand_total'),
            'ordersChart' => $this->buildOrderCountChart($user),
            'spendChart' => $this->buildSpendChart($user),
            'recentOrders' => (clone $ordersQuery)
                ->with('items.product')
                ->latest()
                ->limit(5)
                ->get(),
            'recentRfqs' => (clone $rfqsQuery)
                ->with('supplier:id,company_name')
                ->latest()
                ->limit(5)
                ->get(),
            'recentTickets' => (clone $ticketsQuery)
                ->with(['supplier:id,company_name', 'assignee:id,name'])
                ->latest()
                ->limit(5)
                ->get(),
            'customerId' => $customerId,
        ];
    }

    private function buildOrderCountChart(User $user): array
    {
        $startDate = CarbonImmutable::today()->subDays(29);

        $counts = Order::query()
            ->selectRaw('DATE(created_at) as chart_date, COUNT(*) as aggregate')
            ->whereHas('customer', fn (Builder $query) => $query->where('user_id', $user->id))
            ->whereDate('created_at', '>=', $startDate->toDateString())
            ->groupBy('chart_date')
            ->pluck('aggregate', 'chart_date');

        $period = collect(range(0, 29))->map(fn (int $offset): CarbonImmutable => $startDate->addDays($offset));

        return [
            'labels' => $period->map(fn (CarbonImmutable $date): string => $date->format('M d'))->all(),
            'series' => $period->map(fn (CarbonImmutable $date): int => (int) ($counts[$date->toDateString()] ?? 0))->all(),
        ];
    }

    private function buildSpendChart(User $user): array
    {
        $startDate = CarbonImmutable::today()->startOfMonth()->subMonths(5);

        $spend = Order::query()
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-01') as chart_month, SUM(grand_total) as aggregate")
            ->whereHas('customer', fn (Builder $query) => $query->where('user_id', $user->id))
            ->whereDate('created_at', '>=', $startDate->toDateString())
            ->groupBy('chart_month')
            ->pluck('aggregate', 'chart_month');

        $period = collect(range(0, 5))->map(fn (int $offset): CarbonImmutable => $startDate->addMonths($offset));

        return [
            'labels' => $period->map(fn (CarbonImmutable $date): string => $date->format('M Y'))->all(),
            'series' => $period->map(fn (CarbonImmutable $date): float => round((float) ($spend[$date->format('Y-m-01')] ?? 0), 2))->all(),
        ];
    }
}
