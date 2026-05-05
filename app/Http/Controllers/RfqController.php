<?php

namespace App\Http\Controllers;

use App\Events\RfqCreated;
use App\Http\Requests\Rfq\StoreRfqRequest;
use App\Models\Rfq;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RfqController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $query = Rfq::query()
            ->with(['buyer', 'supplier.user'])
            ->latest();

        if ($user?->hasRole('admin')) {
            // Admin sees all RFQs.
        } elseif ($user?->hasRole('supplier')) {
            $supplier = $user->supplier;
            abort_if($supplier?->status !== 'approved', 403, 'Approved supplier account required.');

            $query->where('supplier_id', $supplier->id);
        } else {
            $query->where('buyer_id', $user?->id);
        }

        return view('rfqs.index', [
            'rfqs' => $query->paginate(10)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        abort_if(auth()->user()?->hasRole('supplier'), 403, 'Suppliers cannot create buyer RFQs.');

        return view('rfqs.create', [
            'suppliers' => Supplier::query()
                ->where('status', 'approved')
                ->orderBy('company_name')
                ->get(),
        ]);
    }

    public function store(StoreRfqRequest $request): RedirectResponse
    {
        abort_if($request->user()?->hasRole('supplier'), 403, 'Suppliers cannot create buyer RFQs.');

        $rfq = Rfq::query()->create([
            ...$request->validated(),
            'buyer_id' => $request->user()->id,
            'status' => 'open',
        ]);

        event(new RfqCreated($rfq));

        return redirect()
            ->route('rfqs.show', $rfq)
            ->with('success', 'RFQ created successfully.');
    }

    public function show(Rfq $rfq): View
    {
        $rfq->load(['buyer', 'supplier.user']);
        $user = auth()->user();

        if (! $user?->hasRole('admin')) {
            if ($user?->hasRole('supplier')) {
                $supplier = $user->supplier;
                abort_if($supplier?->status !== 'approved' || $rfq->supplier_id !== $supplier?->id, 403);
            } else {
                abort_if($rfq->buyer_id !== $user?->id, 403);
            }
        }

        return view('rfqs.show', [
            'rfq' => $rfq,
        ]);
    }
}
