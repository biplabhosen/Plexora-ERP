<?php

namespace App\Http\Controllers;

use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Models\Supplier;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class SupplierController extends Controller
{
    public function create(): View
    {
        return view('suppliers.create', [
            'supplierApplication' => Auth::user()->supplier,
        ]);
    }

    public function store(StoreSupplierRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $existingApplication = $user->supplier;
        $payload = array_merge($request->validated(), [
            'status' => 'pending',
            'approved_by' => null,
            'approved_at' => null,
        ]);

        if ($existingApplication?->status === 'approved') {
            return redirect()
                ->route('dashboard')
                ->with('info', 'Your supplier account is already approved.');
        }

        if ($existingApplication?->status === 'pending') {
            return redirect()
                ->route('become-supplier')
                ->with('info', 'Your supplier application is already pending review.');
        }

        if ($existingApplication?->status === 'rejected') {
            $existingApplication->update($payload);

            return redirect()
                ->route('become-supplier')
                ->with('success', 'Supplier application resubmitted for review.');
        }

        Supplier::create($payload + ['user_id' => $user->id]);

        return redirect()->route('become-supplier')
            ->with('success', 'Supplier application submitted for review.');
    }
}
