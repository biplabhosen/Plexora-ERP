<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()
            ->with('supplier')
            ->search($request->string('search')->toString())
            ->latest();

        if ($this->isSupplierUser()) {
            $supplier = $this->currentApprovedSupplier();
            $query->where('supplier_id', $supplier?->id ?? 0);
        }

        $products = $query->paginate(10)->withQueryString();

        return view('products.index', [
            'products' => $products,
            'search' => $request->string('search')->toString(),
        ]);
    }

    public function create(): View
    {
        return view('products.create', [
            'product' => new Product(['status' => true, 'stock' => 0, 'moq' => 1]),
            'suppliers' => $this->availableSuppliers(),
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $validated = $this->validatedProductData($request->validated());

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        $this->ensureSupplierOwnsProduct($product);

        return view('products.edit', [
            'product' => $product,
            'suppliers' => $this->availableSuppliers(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->ensureSupplierOwnsProduct($product);
        $product->update($this->validatedProductData($request->validated()));

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->ensureSupplierOwnsProduct($product);
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    private function availableSuppliers()
    {
        if ($this->isSupplierUser()) {
            $supplier = $this->currentApprovedSupplier();
            abort_if(! $supplier, 403, 'Approved supplier account required.');

            return Supplier::query()->whereKey($supplier->id)->get();
        }

        return Supplier::query()
            ->where('status', 'approved')
            ->orderBy('company_name')
            ->get();
    }

    private function validatedProductData(array $validated): array
    {
        if ($this->isSupplierUser()) {
            $supplier = $this->currentApprovedSupplier();
            abort_if(! $supplier, 403, 'Approved supplier account required.');
            $validated['supplier_id'] = $supplier->id;
        } else {
            $isApprovedSupplier = Supplier::query()
                ->whereKey($validated['supplier_id'])
                ->where('status', 'approved')
                ->exists();

            abort_if(! $isApprovedSupplier, 422, 'Products can only be assigned to approved suppliers.');
        }

        return $validated;
    }

    private function ensureSupplierOwnsProduct(Product $product): void
    {
        if (! $this->isSupplierUser()) {
            return;
        }

        $supplier = $this->currentApprovedSupplier();
        abort_if(! $supplier || $product->supplier_id !== $supplier->id, 403);
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
