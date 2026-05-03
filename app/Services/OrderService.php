<?php

namespace App\Services;

use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function __construct(
        private readonly InventoryService $inventoryService
    ) {}

    public function place(array $data, User $user): Order
    {
        return DB::transaction(function () use ($data, $user): Order {
            $products = $this->loadProducts($data['items']);

            $this->validateStock($data['items'], $products);

            $subtotal = $this->calculateSubtotal($data['items'], $products);

            $order = Order::create([
                'customer_id' => $user->id,
                'order_number' => $this->generateOrderNumber(),
                'subtotal' => $subtotal,
                'discount' => 0,
                'tax' => 0,
                'grand_total' => $subtotal,
                'status' => 'pending',
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                $product = $products->get((int) $item['product_id']);
                $quantity = (int) $item['quantity'];
                $lineTotal = (float) $product->price * $quantity;

                $order->items()->create([
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'line_total' => $lineTotal,
                ]);

                $this->inventoryService->deduct($product, $quantity);
            }

            event(new OrderPlaced($order));

            return $order->load(['items.product', 'customer']);
        });
    }

    private function loadProducts(array $items): Collection
    {
        $productIds = collect($items)->pluck('product_id')->map(fn ($id): int => (int) $id)->unique();

        return Product::query()
            ->whereIn('id', $productIds)
            ->lockForUpdate()
            ->get()
            ->keyBy('id');
    }

    private function validateStock(array $items, Collection $products): void
    {
        $quantitiesByProduct = collect($items)
            ->groupBy(fn (array $item): int => (int) $item['product_id'])
            ->map(fn (Collection $items): int => $items->sum(fn (array $item): int => (int) $item['quantity']));

        foreach ($items as $index => $item) {
            $productId = (int) $item['product_id'];
            $product = $products->get($productId);

            if (! $product || $product->stock < $quantitiesByProduct->get($productId)) {
                throw ValidationException::withMessages([
                    "items.{$index}.quantity" => 'Requested quantity is not available in stock.',
                ]);
            }
        }
    }

    private function calculateSubtotal(array $items, Collection $products): float
    {
        return collect($items)->sum(function (array $item) use ($products): float {
            $product = $products->get((int) $item['product_id']);

            return (float) $product->price * (int) $item['quantity'];
        });
    }

    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-'.now()->format('Ymd').'-'.str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (Order::query()->where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
