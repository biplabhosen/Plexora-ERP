<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AutomationRuleController;
use App\Http\Controllers\Buyer\BuyerDashboardController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\RfqController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Supplier\SupplierDashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierApprovalController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\SupportReplyController;
use App\Http\Controllers\SupportTicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::prefix('admin')
    ->middleware(['auth', 'role:admin,marketing_manager,support_agent'])
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');
    });

Route::prefix('buyer')
    ->middleware(['auth', 'role:buyer'])
    ->group(function () {
        Route::get('/dashboard', [BuyerDashboardController::class, 'index'])
            ->name('buyer.dashboard');
    });

Route::prefix('supplier')
    ->middleware(['auth', 'role:supplier'])
    ->group(function () {
        Route::get('/dashboard', [SupplierDashboardController::class, 'index'])
            ->name('supplier.dashboard');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Supplier application routes (buyer)
    Route::get('/become-supplier', [SupplierController::class, 'create'])
        ->middleware('module:suppliers')
        ->name('become-supplier');
    Route::post('/become-supplier', [SupplierController::class, 'store'])
        ->middleware('module:suppliers')
        ->name('become-supplier.store');

    Route::get('/inventory', [InventoryController::class, 'index'])->middleware('module:inventory')->name('inventory.index');
    Route::get('/inventory/low-stock', [InventoryController::class, 'lowStock'])->middleware('module:inventory')->name('inventory.low-stock');
    Route::get('/inventory/logs', [InventoryController::class, 'logs'])->middleware('module:inventory')->name('inventory.logs');
    Route::get('/inventory/{product}/adjust', [InventoryController::class, 'adjust'])->middleware('module:inventory')->name('inventory.adjust');
    Route::post('/inventory/{product}/adjust', [InventoryController::class, 'update'])->middleware('module:inventory')->name('inventory.update');
    Route::resource('customers', CustomerController::class)
        ->only(['index', 'show'])
        ->middleware('module:crm');
    Route::post('/customers/{customer}/notes', [CustomerController::class, 'storeNote'])->middleware('module:crm')->name('customers.notes.store');
    Route::resource('leads', LeadController::class)
        ->except(['show'])
        ->middleware('module:crm');
});

Route::resource('products', ProductController::class)
    ->except('show')
    ->middleware(['auth', 'module:products']);

Route::resource('orders', OrderController::class)
    ->only(['index', 'create', 'store', 'show'])
    ->middleware(['auth', 'module:orders']);

Route::middleware('auth')->group(function () {
    Route::resource('support-tickets', SupportTicketController::class)
        ->only(['index', 'create', 'store', 'show'])
        ->middleware('module:support');
    Route::post('/support-tickets/{supportTicket}/reply', [SupportReplyController::class, 'store'])
        ->middleware('module:support')
        ->name('support.reply');
    Route::patch('/support-tickets/{supportTicket}/status', [SupportTicketController::class, 'updateStatus'])
        ->middleware('module:support')
        ->name('support.status');
    Route::resource('rfqs', RfqController::class)
        ->only(['index', 'create', 'store', 'show'])
        ->middleware('module:rfq');
});

Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('suppliers', [SupplierApprovalController::class, 'index'])
            ->middleware('module:suppliers')
            ->name('suppliers.index');
        Route::post('suppliers/{supplier}/approve', [SupplierApprovalController::class, 'approve'])
            ->middleware('module:suppliers')
            ->name('suppliers.approve');
        Route::post('suppliers/{supplier}/reject', [SupplierApprovalController::class, 'reject'])
            ->middleware('module:suppliers')
            ->name('suppliers.reject');

        Route::resource('users', UserManagementController::class)
            ->except(['show', 'destroy']);
        Route::patch('users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])
            ->name('users.toggle-status');

        Route::get('modules', [ModuleController::class, 'index'])->name('modules.index');
        Route::patch('modules', [ModuleController::class, 'update'])->name('modules.update');

        Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    });

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/automation/logs', [AutomationRuleController::class, 'logs'])
        ->middleware('module:workflow')
        ->name('automation.logs');
    Route::resource('automation', AutomationRuleController::class)
        ->except(['show'])
        ->middleware('module:workflow');
});

Route::middleware(['auth', 'role:admin,marketing_manager', 'module:marketing,social'])->group(function () {
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::post('/campaigns/{campaign}/run', [CampaignController::class, 'run'])->name('campaigns.run');
    Route::resource('campaigns', CampaignController::class);
    Route::resource('templates', TemplateController::class)
        ->except(['show'])
        ->middleware('module:marketing');
});

require __DIR__.'/auth.php';
