<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierApprovalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Supplier application routes (buyer)
    Route::get('/become-supplier', [SupplierController::class, 'create'])->name('become-supplier');
    Route::post('/become-supplier', [SupplierController::class, 'store'])->name('become-supplier.store');
});

Route::resource('products', ProductController::class)
    ->except('show')
    ->middleware('auth');

Route::resource('orders', OrderController::class)
    ->only(['index', 'create', 'store', 'show'])
    ->middleware('auth');

// Admin supplier approval routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/suppliers', [SupplierApprovalController::class, 'index'])->name('admin.suppliers.index');
    Route::post('/admin/suppliers/{supplier}/approve', [SupplierApprovalController::class, 'approve'])->name('admin.suppliers.approve');
    Route::post('/admin/suppliers/{supplier}/reject', [SupplierApprovalController::class, 'reject'])->name('admin.suppliers.reject');

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});

require __DIR__.'/auth.php';
