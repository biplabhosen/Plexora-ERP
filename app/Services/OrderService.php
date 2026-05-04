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
    private const STATUS_PENDING = 'pending';

    private const TAX_CENTS = 0;

    public function __construct(
        private readonly InventoryService $inventoryService
    ) {}

    public function place(array $data, User $user): Order
    {
        return DB::transaction(function () use ($data, $user): Order {
            $items = $this->normalizeItems($data['items']);
            $products = $this->loadProducts($items);

            $this->validateItems($items, $products);

            $pricedItems = $this->priceItems($items, $products);
            $totals = $this->calculateTotals($pricedItems);

            $order = Order::query()->create([
                'customer_id' => $data['customer_id'] ?? $user->id,
                'order_number' => $this->generateOrderNumber(),
                'subtotal' => $this->formatCents($totals['subtotal_cents']),
                'discount' => $this->formatCents($totals['discount_cents']),
                'tax' => $this->formatCents(self::TAX_CENTS),
                'grand_total' => $this->formatCents($totals['grand_total_cents']),
                'status' => self::STATUS_PENDING,
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($pricedItems as $item) {
                $order->items()->create([
                    'product_id' => $item['product']->id,
                    'price' => $this->formatCents($item['base_unit_price_cents']),
                    'quantity' => $item['quantity'],
                    'line_total' => $this->formatCents($item['line_total_cents']),
                ]);

                $this->inventoryService->deduct($item['product'], $item['quantity']);
            }

            event(new OrderPlaced($order));

            return $order->load(['items.product', 'customer']);
        });
    }

    private function normalizeItems(array $items): array
    {
        return collect($items)
            ->map(fn (array $item): array => [
                'product_id' => (int) $item['product_id'],
                'quantity' => (int) $item['quantity'],
            ])
            ->values()
            ->all();
    }

    private function loadProducts(array $items): Collection
    {
        $productIds = collect($items)->pluck('product_id')->unique()->values();

        return Product::query()
            ->whereIn('id', $productIds)
            ->lockForUpdate()
            ->get()
            ->keyBy('id');
    }

    private function validateItems(array $items, Collection $products): void
    {
        $quantitiesByProduct = collect($items)
            ->groupBy('product_id')
            ->map(fn (Collection $items): int => $items->sum('quantity'));

        foreach ($items as $index => $item) {
            $product = $products->get($item['product_id']);

            if (! $product) {
                throw ValidationException::withMessages([
                    "items.{$index}.product_id" => 'Selected product is not available.',
                ]);
            }

            $requestedQuantity = (int) $quantitiesByProduct->get($product->id);

            if ($item['quantity'] < $product->moq) {
                throw ValidationException::withMessages([
                    "items.{$index}.quantity" => "MOQ for {$product->name} is {$product->moq} units.",
                ]);
            }

            if ($requestedQuantity > $product->stock) {
                throw ValidationException::withMessages([
                    "items.{$index}.quantity" => "Only {$product->stock} units available for {$product->name}.",
                ]);
            }
        }
    }

    private function priceItems(array $items, Collection $products): array
    {
        return collect($items)
            ->map(function (array $item) use ($products): array {
                $product = $products->get($item['product_id']);
                $quantity = $item['quantity'];
                $baseUnitPriceCents = $this->moneyToCents($product->price);
                $discountRateBasisPoints = $this->bulkDiscountRateBasisPoints($quantity);
                $lineSubtotalCents = $baseUnitPriceCents * $quantity;
                $discountCents = intdiv($lineSubtotalCents * $discountRateBasisPoints, 10_000);
                $lineTotalCents = $lineSubtotalCents - $discountCents;

                return [
                    'product' => $product,
                    'quantity' => $quantity,
                    'base_unit_price_cents' => $baseUnitPriceCents,
                    'discount_cents' => $discountCents,
                    'line_subtotal_cents' => $lineSubtotalCents,
                    'line_total_cents' => $lineTotalCents,
                ];
            })
            ->values()
            ->all();
    }

    private function calculateTotals(array $pricedItems): array
    {
        $subtotalCents = collect($pricedItems)->sum('line_subtotal_cents');
        $discountCents = collect($pricedItems)->sum('discount_cents');
        $grandTotalCents = $subtotalCents - $discountCents + self::TAX_CENTS;

        return [
            'subtotal_cents' => $subtotalCents,
            'discount_cents' => $discountCents,
            'grand_total_cents' => max(0, $grandTotalCents),
        ];
    }

    private function bulkDiscountRateBasisPoints(int $quantity): int
    {
        return match (true) {
            $quantity >= 50 => 1_000,
            $quantity >= 20 => 500,
            $quantity >= 10 => 200,
            default => 0,
        };
    }

    private function moneyToCents(string|float|int $amount): int
    {
        return (int) round((float) $amount * 100);
    }

    private function formatCents(int $cents): string
    {
        return number_format($cents / 100, 2, '.', '');
    }

    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-'.now()->format('Ymd').'-'.str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (Order::query()->where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
