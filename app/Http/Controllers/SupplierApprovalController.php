<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SupplierApprovalController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();
        $allowedStatuses = ['pending', 'approved', 'rejected'];

        $suppliers = Supplier::query()
            ->with(['user', 'approver'])
            ->when(in_array($status, $allowedStatuses, true), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderByRaw("
                CASE status
                    WHEN 'pending' THEN 0
                    WHEN 'approved' THEN 1
                    ELSE 2
                END
            ")
            ->orderByDesc('created_at')
            ->get();

        $counts = Supplier::query()
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return view('admin.suppliers.index', [
            'suppliers' => $suppliers,
            'status' => in_array($status, $allowedStatuses, true) ? $status : null,
            'counts' => $counts,
        ]);
    }

    public function approve(Supplier $supplier): RedirectResponse
    {
        $admin = Auth::user();
        $supplierRole = Role::firstOrCreate(['name' => 'supplier']);

        $supplier->update([
            'status'      => 'approved',
            'approved_by' => $admin->id,
            'approved_at' => now(),
        ]);

        $supplier->user()->update(['role_id' => $supplierRole->id]);

        return redirect()->back()->with('success', 'Supplier approved.');
    }

    public function reject(Supplier $supplier): RedirectResponse
    {
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $supplier->update([
            'status' => 'rejected',
            'approved_by' => null,
            'approved_at' => null,
        ]);

        $supplier->user()->update(['role_id' => $userRole->id]);

        return redirect()->back()->with('info', 'Supplier rejected.');
    }
}
