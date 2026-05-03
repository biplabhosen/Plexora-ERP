<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $orders = Order::query()
            ->with('customer')
            ->status($status)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('orders.index', [
            'orders' => $orders,
            'status' => $status,
        ]);
    }

    public function create(): View
    {
        return view('orders.create', [
            'products' => Product::query()->active()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreOrderRequest $request, OrderService $orderService): RedirectResponse
    {
        $order = $orderService->place($request->validated(), $request->user());

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order placed successfully.');
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'customer']);

        return view('orders.show', [
            'order' => $order,
        ]);
    }
}
