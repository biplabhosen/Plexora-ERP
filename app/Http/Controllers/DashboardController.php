<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index(): RedirectResponse
    {
        $role = auth()->user()?->role?->name;

        return match (str($role)->lower()->replace([' ', '-'], '_')->toString()) {
            'admin', 'marketing_manager', 'support_agent' => redirect()->route('admin.dashboard'),
            'buyer', 'user' => redirect()->route('buyer.dashboard'),
            'supplier' => redirect()->route('supplier.dashboard'),
            default => abort(403),
        };
    }
}
