<?php

use App\Http\Controllers\AutomationRuleController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\RfqController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierApprovalController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::get('/dashboard', DashboardController::class)
    ->middleware('auth',)
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Supplier application routes (buyer)
    Route::get('/become-supplier', [SupplierController::class, 'create'])->name('become-supplier');
    Route::post('/become-supplier', [SupplierController::class, 'store'])->name('become-supplier.store');

    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/low-stock', [InventoryController::class, 'lowStock'])->name('inventory.low-stock');
    Route::get('/inventory/logs', [InventoryController::class, 'logs'])->name('inventory.logs');
    Route::get('/inventory/{product}/adjust', [InventoryController::class, 'adjust'])->name('inventory.adjust');
    Route::post('/inventory/{product}/adjust', [InventoryController::class, 'update'])->name('inventory.update');
    Route::resource('customers', CustomerController::class)
        ->only(['index', 'show']);
    Route::post('/customers/{customer}/notes', [CustomerController::class, 'storeNote'])->name('customers.notes.store');
    Route::resource('leads', LeadController::class)
        ->except(['show']);
});

Route::resource('products', ProductController::class)
    ->except('show')
    ->middleware('auth');

Route::resource('orders', OrderController::class)
    ->only(['index', 'create', 'store', 'show'])
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::resource('rfqs', RfqController::class)
        ->only(['index', 'create', 'store', 'show']);
});

// Admin supplier approval routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/suppliers', [SupplierApprovalController::class, 'index'])->name('admin.suppliers.index');
    Route::post('/admin/suppliers/{supplier}/approve', [SupplierApprovalController::class, 'approve'])->name('admin.suppliers.approve');
    Route::post('/admin/suppliers/{supplier}/reject', [SupplierApprovalController::class, 'reject'])->name('admin.suppliers.reject');

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/automation/logs', [AutomationRuleController::class, 'logs'])->name('automation.logs');
    Route::resource('automation', AutomationRuleController::class)
        ->except(['show']);

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::post('/campaigns/{campaign}/run', [CampaignController::class, 'run'])->name('campaigns.run');
    Route::resource('campaigns', CampaignController::class);
    Route::resource('templates', TemplateController::class)
        ->except(['show']);
});

require __DIR__.'/auth.php';
