<?php

namespace App\Http\Controllers;

use App\Http\Requests\Inventory\AdjustStockRequest;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Services\InventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function __construct(
        private readonly InventoryService $inventoryService
    ) {}

    public function index(): View
    {
        $query = $this->inventoryProductQuery()->with('supplier')->latest('id');

        $products = $query->paginate(10);
        $inventoryScope = $this->inventoryProductQuery();

        return view('inventory.index', [
            'products' => $products,
            'totalProducts' => (clone $inventoryScope)->count(),
            'lowStockCount' => (clone $inventoryScope)->lowStock()->count(),
            'outOfStockCount' => (clone $inventoryScope)->where('stock', '<=', 0)->count(),
        ]);
    }

    public function lowStock(): View
    {
        $products = $this->inventoryProductQuery()
            ->with('supplier')
            ->lowStock()
            ->latest('id')
            ->paginate(10);

        return view('inventory.low-stock', [
            'products' => $products,
        ]);
    }

    public function logs(Request $request): View
    {
        $query = StockMovement::query()
            ->with(['product.supplier', 'user'])
            ->latest();

        if ($this->isSupplierUser()) {
            $supplier = $this->currentApprovedSupplier();
            $query->whereHas('product', fn ($productQuery) => $productQuery->where('supplier_id', $supplier?->id ?? 0));
        } else {
            $this->ensureInventoryAccess();
        }

        $selectedProduct = null;

        if ($request->filled('product')) {
            $selectedProduct = $this->inventoryProductQuery()->findOrFail((int) $request->integer('product'));
            $query->where('product_id', $selectedProduct->id);
        }

        return view('inventory.logs', [
            'movements' => $query->paginate(20)->withQueryString(),
            'selectedProduct' => $selectedProduct,
        ]);
    }

    public function adjust(Product $product): View
    {
        $this->ensureInventoryAccess();
        $this->ensureSupplierOwnsProduct($product);

        return view('inventory.adjust', [
            'product' => $product->loadMissing('supplier'),
        ]);
    }

    public function update(AdjustStockRequest $request, Product $product): RedirectResponse
    {
        $this->ensureInventoryAccess();
        $this->ensureSupplierOwnsProduct($product);

        $this->inventoryService->adjust(
            $product,
            $request->string('type')->toString(),
            (int) $request->integer('quantity'),
            $request->validated('note')
        );

        return redirect()
            ->route('inventory.index')
            ->with('success', "Stock updated successfully for {$product->name}.");
    }

    private function inventoryProductQuery()
    {
        $this->ensureInventoryAccess();

        $query = Product::query();

        if ($this->isSupplierUser()) {
            $supplier = $this->currentApprovedSupplier();
            $query->where('supplier_id', $supplier?->id ?? 0);
        }

        return $query;
    }

    private function ensureSupplierOwnsProduct(Product $product): void
    {
        if (! $this->isSupplierUser()) {
            return;
        }

        $supplier = $this->currentApprovedSupplier();
        abort_if(! $supplier || $product->supplier_id !== $supplier->id, 403);
    }

    private function ensureInventoryAccess(): void
    {
        $user = auth()->user();

        abort_unless($user?->hasRole('admin') || $user?->hasRole('supplier'), 403);

        if ($user->hasRole('supplier')) {
            abort_unless($this->currentApprovedSupplier(), 403, 'Approved supplier account required.');
        }
    }

    private function currentApprovedSupplier(): ?Supplier
    {
        $supplier = auth()->user()?->supplier;

        return $supplier?->status === 'approved' ? $supplier : null;
    }

    private function isSupplierUser(): bool
    {
        return auth()->user()?->hasRole('supplier') ?? false;
    }
}
