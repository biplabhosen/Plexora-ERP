<?php

namespace App\Services;

use App\Models\Product;

class InventoryService
{
    public function deduct(Product $product, int $qty): void
    {
        $product->decrement('stock', $qty);
    }
}
