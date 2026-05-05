<?php

namespace App\Services\Dashboard;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Rfq;
use App\Models\SupportTicket;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class SupplierDashboardService
{
    public function getMetrics(User $user): array
    {
        $supplier = $user->supplier;
        $supplierId = $supplier?->id;

        $productsQuery = Product::query()->where('supplier_id', $supplierId ?? 0);
        $orderItemsQuery = OrderItem::query()
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('products.supplier_id', $supplierId ?? 0);

        $ordersQuery = Order::query()
            ->with(['customer', 'items.product'])
            ->whereHas('items.product', fn (Builder $query) => $query->where('supplier_id', $supplierId ?? 0));

        $rfqsQuery = Rfq::query()->where('supplier_id', $supplierId ?? 0);
        $ticketsQuery = SupportTicket::query()->where('supplier_id', $supplierId ?? 0);

        return [
            'supplierStatus' => $supplier?->status,
            'myProducts' => (clone $productsQuery)->count(),
            'pendingOrders' => (clone $ordersQuery)->where('status', 'pending')->count(),
            'confirmedOrders' => (clone $ordersQuery)->where('status', 'confirmed')->count(),
            'revenue' => (float) (clone $orderItemsQuery)->sum('order_items.line_total'),
            'openRfqs' => (clone $rfqsQuery)->open()->count(),
            'lowStockItems' => (clone $productsQuery)->whereColumn('stock', '<=', 'moq')->count(),
            'salesChart' => $this->buildSalesChart($supplierId),
            'productPerformance' => $this->buildProductPerformanceChart($supplierId),
            'recentOrders' => (clone $ordersQuery)->latest()->limit(5)->get(),
            'assignedRfqs' => (clone $rfqsQuery)
                ->with('buyer:id,name,email')
                ->latest()
                ->limit(5)
                ->get(),
            'lowStockProducts' => (clone $productsQuery)
                ->lowStock()
                ->latest()
                ->limit(5)
                ->get(),
        ];
    }

    private function buildSalesChart(?int $supplierId): array
    {
        $startDate = CarbonImmutable::today()->subDays(29);

        $sales = OrderItem::query()
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->selectRaw('DATE(orders.created_at) as chart_date, SUM(order_items.line_total) as aggregate')
            ->where('products.supplier_id', $supplierId ?? 0)
            ->whereDate('orders.created_at', '>=', $startDate->toDateString())
            ->groupBy('chart_date')
            ->pluck('aggregate', 'chart_date');

        $period = collect(range(0, 29))->map(fn (int $offset): CarbonImmutable => $startDate->addDays($offset));

        return [
            'labels' => $period->map(fn (CarbonImmutable $date): string => $date->format('M d'))->all(),
            'series' => $period->map(fn (CarbonImmutable $date): float => round((float) ($sales[$date->toDateString()] ?? 0), 2))->all(),
        ];
    }

    private function buildProductPerformanceChart(?int $supplierId): array
    {
        $items = OrderItem::query()
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->where('products.supplier_id', $supplierId ?? 0)
            ->groupBy('products.name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        return [
            'labels' => $items->pluck('name')->all(),
            'series' => $items->pluck('total_quantity')->map(fn ($quantity): int => (int) $quantity)->all(),
        ];
    }
}
