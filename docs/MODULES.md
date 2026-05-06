# Module Configuration - Plexora ERP

## Overview

The Plexora ERP uses a modular architecture where features can be enabled/disabled independently. This document explains how to configure and manage modules.

## Module List

| Module Key | Name | Description | Default |
|------------|------|-------------|---------|
| `suppliers` | Supplier Module | Multi-vendor marketplace | Enabled |
| `products` | Product Management | Product catalog and inventory | Enabled |
| `orders` | Order Management | Order processing system | Enabled |
| `crm` | CRM Module | Customer and lead management | Enabled |
| `marketing` | Marketing Module | Campaign management | Enabled |
| `workflow` | Workflow Engine | Automation rules engine | Enabled |
| `social` | Social Media Module | Social posting integration | Enabled |
| `inventory` | Inventory Module | Stock tracking and adjustment | Enabled |
| `support` | Support Module | Ticketing system | Enabled |
| `rfq` | RFQ Module | Request for quotation | Enabled |

## Configuration Methods

### Method 1: Admin Panel (Recommended)

1. Navigate to **Admin > Modules**
2. Toggle switches to enable/disable modules
3. Changes take effect immediately

### Method 2: Database

```sql
-- View current module settings
SELECT * FROM settings WHERE key LIKE 'module.%';

-- Disable a module
UPDATE settings SET value = '0' WHERE key = 'module.suppliers';

-- Enable a module
UPDATE settings SET value = '1' WHERE key = 'module.suppliers';
```

### Method 3: Command Line

```bash
# Use Tinker
php artisan tinker

# Disable module
App\Models\Setting::updateOrCreate(
    ['key' => 'module.suppliers'],
    ['value' => '0']
);

# Enable module
App\Models\Setting::updateOrCreate(
    ['key' => 'module.suppliers'],
    ['value' => '1']
);
```

## Module Dependencies

| Module | Depends On |
|--------|------------|
| `products` | `suppliers` |
| `orders` | `customers`, `products` |
| `crm` | None (standalone) |
| `marketing` | `crm` |
| `workflow` | `automation_rules` table |
| `social` | None (standalone) |
| `inventory` | `products` |
| `support` | None (standalone) |
| `rfq` | `suppliers` |

## Route Protection

Modules are protected via middleware in routes:

```php
// Example: Supplier module routes
Route::middleware(['auth', 'module:suppliers'])->group(function () {
    Route::get('/become-supplier', [SupplierController::class, 'create']);
    Route::post('/become-supplier', [SupplierController::class, 'store']);
});

// Example: CRM module routes
Route::middleware(['auth', 'module:crm'])->group(function () {
    Route::resource('customers', CustomerController::class);
    Route::resource('leads', LeadController::class);
});
```

## Check Module Status in Code

```php
// In controllers/services
if (app(\App\Services\ModuleService::class)->enabled('suppliers')) {
    // Module is enabled
}

// In Blade templates
@moduleEnabled('suppliers')
    <!-- Content only shown if module enabled -->
@endmoduleEnabled

// Alternative
@if(app(\App\Services\ModuleService::class)->enabled('suppliers'))
    <div>Module content</div>
@endif
```

## Default Module Status

When fresh installation occurs, the following modules are enabled by default:

| Module | Enabled |
|--------|---------|
| suppliers | Yes |
| products | Yes |
| orders | Yes |
| crm | Yes |
| marketing | Yes |
| workflow | Yes |
| social | Yes |
| inventory | Yes |
| support | Yes |
| rfq | Yes |

## Adding a Custom Module

### Step 1: Create Module Service

```php
// app/Services/MyCustomModuleService.php
namespace App\Services;

class MyCustomModuleService
{
    public function enabled(): bool
    {
        return app(\App\Services\ModuleService::class)->enabled('my_custom_module');
    }

    public function name(): string
    {
        return 'My Custom Module';
    }
}
```

### Step 2: Register in ModuleService

```php
// app/Services/ModuleService.php
public function all(): array
{
    return [
        'suppliers' => 'Supplier Module',
        'products' => 'Product Management',
        // ... existing modules ...
        'my_custom_module' => 'My Custom Module',  // Add here
    ];
}
```

### Step 3: Add Routes with Module Middleware

```php
// routes/web.php
Route::middleware(['auth', 'module:my_custom_module'])->group(function () {
    Route::get('/custom-module', [CustomModuleController::class, 'index']);
});
```

### Step 4: Add to Admin Panel

```php
// app/Http/Controllers/Admin/ModuleController.php
public function index(): View
{
    $modules = [
        'suppliers' => [
            'name' => 'Supplier Module',
            'description' => 'Multi-vendor marketplace',
            'enabled' => $this->moduleService->enabled('suppliers'),
        ],
        // ... existing modules ...
        'my_custom_module' => [
            'name' => 'My Custom Module',
            'description' => 'Custom feature description',
            'enabled' => $this->moduleService->enabled('my_custom_module'),
        ],
    ];

    return view('admin.modules.index', compact('modules'));
}
```

## Troubleshooting

### Module Not Disappearing After Disable

1. Clear application cache:
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

2. Check database directly:
```sql
SELECT * FROM settings WHERE key = 'module.suppliers';
```

3. Verify middleware is applied to routes.

### Module Enabled but Routes Not Working

1. Check if routes are properly wrapped in module middleware
2. Verify the module service implements `enabled()` method
3. Clear route cache: `php artisan route:clear`

### Database Errors After Enabling Module

1. Run migrations for the module:
```bash
php artisan migrate --path=database/migrations/module_name
```

2. Check module seeder:
```bash
php artisan db:seed --class=ModuleNameSeeder
```

---

## Module Migration Guide

### Creating Module-Specific Migrations

```bash
# Create migration for specific module
php artisan make:migration create_products_table --module=products
```

### Module-Specific Seeders

```bash
# Create seeder for specific module
php artisan make:seeder ProductSeeder
```

Add to DatabaseSeeder:
```php
$this->call([
    // ... other seeders ...
    \Database\Seeders\ProductSeeder::class,
]);
```

---

**Version:** 1.0.0  
**Last Updated:** May 2026
