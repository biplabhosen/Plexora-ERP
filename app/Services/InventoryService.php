<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InventoryService
{
    public function add(Product $product, int $qty, ?string $note = null): Product
    {
        return DB::transaction(function () use ($product, $qty, $note): Product {
            $product->refresh();

            $beforeStock = (int) $product->stock;
            $afterStock = $beforeStock + $qty;

            $product->update([
                'stock' => $afterStock,
            ]);

            $this->createMovement($product, 'in', $qty, $beforeStock, $afterStock, null, $note);

            return $product->refresh();
        });
    }

    public function deduct(Product $product, int $qty, ?string $reference = null, ?string $note = null): Product
    {
        return DB::transaction(function () use ($product, $qty, $reference, $note): Product {
            $product->refresh();

            $beforeStock = (int) $product->stock;

            if ($beforeStock < $qty) {
                throw ValidationException::withMessages([
                    'quantity' => "Insufficient stock for {$product->name}. Available stock: {$beforeStock}.",
                ]);
            }

            $afterStock = $beforeStock - $qty;

            $product->update([
                'stock' => $afterStock,
            ]);

            $this->createMovement($product, 'out', $qty, $beforeStock, $afterStock, $reference, $note);

            return $product->refresh();
        });
    }

    public function adjust(Product $product, string $type, int $qty, ?string $note = null): Product
    {
        return match ($type) {
            'add' => $this->add($product, $qty, $note),
            'remove' => $this->deduct($product, $qty, null, $note),
            'set' => $this->setStock($product, $qty, $note),
            default => throw ValidationException::withMessages([
                'type' => 'Invalid stock adjustment type supplied.',
            ]),
        };
    }

    private function setStock(Product $product, int $qty, ?string $note = null): Product
    {
        return DB::transaction(function () use ($product, $qty, $note): Product {
            $product->refresh();

            $beforeStock = (int) $product->stock;
            $afterStock = $qty;

            $product->update([
                'stock' => $afterStock,
            ]);

            $this->createMovement($product, 'adjustment', $qty, $beforeStock, $afterStock, null, $note);

            return $product->refresh();
        });
    }

    private function createMovement(
        Product $product,
        string $type,
        int $quantity,
        int $beforeStock,
        int $afterStock,
        ?string $reference = null,
        ?string $note = null
    ): StockMovement {
        return StockMovement::query()->create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'type' => $type,
            'quantity' => $quantity,
            'before_stock' => $beforeStock,
            'after_stock' => $afterStock,
            'reference' => $reference,
            'note' => $note,
        ]);
    }
}
