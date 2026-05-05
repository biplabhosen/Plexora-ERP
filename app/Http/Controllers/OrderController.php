<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $status = $request->string('status')->toString();
        $isSupplier = $user?->hasRole('supplier') ?? false;
        $supplier = $isSupplier ? $user?->supplier : null;

        $query = Order::query()
            ->with([
                'customer',
                'items.product',
            ])
            ->status($status)
            ->latest();

        if ($isSupplier) {
            abort_if($supplier?->status !== 'approved', 403);

            $query->whereHas('items.product', function (Builder $builder) use ($supplier): void {
                $builder->where('supplier_id', $supplier->id);
            });
        } elseif (! $user?->hasRole('admin')) {
            $query->whereHas('customer', function (Builder $builder) use ($user): void {
                $builder->where('user_id', $user?->id);
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('orders.index', [
            'orders' => $orders,
            'status' => $status,
            'isSupplierView' => $isSupplier,
        ]);
    }

    public function create(): View
    {
        $user = auth()->user();

        abort_if($user?->hasRole('supplier'), 403, 'Suppliers cannot place buyer orders.');

        return view('orders.create', [
            'products' => Product::query()->active()->orderBy('name')->get(),
            'customers' => $user?->hasRole('admin')
                ? Customer::query()->orderBy('name')->get()
                : Customer::query()->where('user_id', $user?->id)->get(),
            'canChooseCustomer' => $user?->hasRole('admin') ?? false,
            'defaultCustomerId' => $user?->customer?->id,
        ]);
    }

    public function store(StoreOrderRequest $request, OrderService $service): RedirectResponse
    {
        abort_if($request->user()?->hasRole('supplier'), 403, 'Suppliers cannot place buyer orders.');

        $order = $service->place(
            $request->validated(),
            auth()->user()
        );

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order placed successfully.');
    }

    public function show(Order $order): View
    {
        $user = auth()->user();
        $isSupplier = $user?->hasRole('supplier') ?? false;

        if ($isSupplier) {
            $supplier = $user?->supplier;
            abort_if($supplier?->status !== 'approved', 403);

            $visibleItems = $order->items()
                ->with('product')
                ->whereHas('product', function (Builder $builder) use ($supplier): void {
                    $builder->where('supplier_id', $supplier->id);
                })
                ->get();

            abort_if($visibleItems->isEmpty(), 403);

            $order->load('customer');
            $order->setRelation('items', $visibleItems);
        } else {
            if (! $user?->hasRole('admin')) {
                abort_if($order->customer?->user_id !== $user?->id, 403);
            }

            $order->load(['items.product', 'customer']);
        }

        $visibleSubtotal = $order->items->sum(fn ($item) => (float) $item->line_total);

        return view('orders.show', [
            'order' => $order,
            'isSupplierView' => $isSupplier,
            'visibleSubtotal' => $visibleSubtotal,
        ]);
    }
}
