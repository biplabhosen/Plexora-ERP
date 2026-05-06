# Developer Guide - Plexora ERP

## Project Structure

```
plexora-erp/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/                    # API controllers
│   │   │   │   └── SupportBotController.php
│   │   │   ├── Admin/                  # Admin panel controllers
│   │   │   │   ├── AdminDashboardController.php
│   │   │   │   ├── ModuleController.php
│   │   │   │   ├── RoleController.php
│   │   │   │   └── UserManagementController.php
│   │   │   ├── Auth/                   # Authentication controllers
│   │   │   ├── Buyer/                  # Buyer dashboard
│   │   │   │   └── BuyerDashboardController.php
│   │   │   ├── Supplier/               # Supplier dashboard
│   │   │   │   └── SupplierDashboardController.php
│   │   │   ├── AdminUserController.php
│   │   │   ├── AutomationRuleController.php
│   │   │   ├── CampaignController.php
│   │   │   ├── CalendarController.php
│   │   │   ├── CustomerController.php
│   │   │   ├── InventoryController.php
│   │   │   ├── LeadController.php
│   │   │   ├── OrderController.php
│   │   │   ├── ProductController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── RfqController.php
│   │   │   ├── SupplierController.php
│   │   │   ├── SupplierApprovalController.php
│   │   │   ├── SupportReplyController.php
│   │   │   ├── SupportTicketController.php
│   │   │   └── TemplateController.php
│   │   ├── Middleware/
│   │   │   ├── EnsureModuleEnabled.php
│   │   │   ├── EnsureRole.php
│   │   │   └── RoleMiddleware.php
│   │   └── Requests/                   # Form validation classes
│   │       ├── Admin/
│   │       ├── Supplier/
│   │       └── Support/
│   ├── Jobs/                           # Queue jobs
│   │   ├── Admin/
│   │   ├── NotifyAdminJob.php
│   │   ├── NotifySupplierJob.php
│   │   ├── PostToSocialMediaJob.php
│   │   ├── RunScheduledCampaignJob.php
│   │   ├── SendCustomerEmailJob.php
│   │   ├── SendMarketingCampaignJob.php
│   │   ├── SendSupportAutoReplyJob.php
│   │   └── SendCustomerEmailJob.php
│   ├── Mail/                           # Mailable classes
│   │   ├── AdminWorkflowMail.php
│   │   ├── CustomerWorkflowMail.php
│   │   └── SupplierWorkflowMail.php
│   ├── Models/                         # Eloquent models
│   │   ├── AutomationRule.php
│   │   ├── Campaign.php
│   │   ├── CampaignLog.php
│   │   ├── Customer.php
│   │   ├── CustomerNote.php
│   │   ├── Lead.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Product.php
│   │   ├── Role.php
│   │   ├── Setting.php
│   │   ├── SocialAccount.php
│   │   ├── StockMovement.php
│   │   ├── Supplier.php
│   │   ├── SupportReply.php
│   │   ├── SupportTicket.php
│   │   ├── User.php
│   │   └── WorkflowLog.php
│   ├── Providers/                      # Service providers
│   │   └── AppServiceProvider.php
│   └── Services/                       # Business logic services
│       ├── AutomationService.php
│       ├── CampaignService.php
│   │   ├── CustomerService.php
│   │   ├── DashboardService.php
│   │   ├── InventoryService.php
│   │   ├── MarketingService.php
│   │   ├── ModuleService.php
│   │   ├── OrderService.php
│   │   ├── SocialPostingService.php
│   │   ├── SupportBotService.php
│   │   ├── SupportService.php
│   │   └── WorkflowLogStatus.php
│   └── Policies/                       # Authorization policies
│       ├── ProductPolicy.php
│       ├── OrderPolicy.php
│       └── SupportTicketPolicy.php
├── database/
│   ├── factories/                      # Model factories
│   │   ├── UserFactory.php
│   │   └── ...
│   ├── migrations/                     # Database migrations
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2026_05_03_105118_create_roles_table.php
│   │   └── ...
│   └── seeders/                        # Database seeders
│       ├── AutomationRuleSeeder.php
│       ├── CampaignSeeder.php
│       ├── DatabaseSeeder.php
│       ├── RoleSeeder.php
│       ├── SettingSeeder.php
│       └── SupportSeeder.php
├── public/                             # Public assets (favicon, robots.txt)
├── resources/
│   ├── css/                            # Global styles
│   ├── js/                             # Frontend JavaScript
│   │   ├── app.js
│   │   └── bootstrap.js
│   ├── lang/                           # Localization
│   │   └── en/
│   │       └── auth.php
│   └── views/                          # Blade templates
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── modules/
│       │   ├── roles/
│       │   └── users/
│       ├── auth/                       # Login, register, etc.
│       ├── buyer/
│       │   └── dashboard.blade.php
│       ├── components/                 # Reusable Blade components
│       │   ├── alert.blade.php
│       │   ├── button.blade.php
│       │   └── card.blade.php
│       ├── emails/                     # Email templates
│       │   ├── customer.blade.php
│       │   └── supplier.blade.php
│       ├── layouts/                    # Master layouts
│       │   ├── app.blade.php
│       │   └── guest.blade.php
│       ├── profile/
│       ├── supplier/
│       │   └── dashboard.blade.php
│       └── support/
│           ├── index.blade.php
│           ├── create.blade.php
│           └── show.blade.php
├── routes/                             # Route definitions
│   ├── api.php                         # API routes
│   ├── auth.php                        # Authentication routes
│   └── web.php                         # Web routes
├── storage/                            # Generated files
│   ├── app/                            # Uploaded files
│   │   └── public/
│   ├── framework/                      # Framework caches
│   └── logs/                           # Application logs
├── tests/                              # PHPUnit tests
│   ├── Feature/
│   └── Unit/
└── .env                                # Environment configuration
```

---

## Adding a New Module

### Step 1: Create Database Migration

```bash
php artisan make:migration create_new_module_table
```

Example migration:

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('new_modules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('new_modules');
    }
};
```

### Step 2: Create Model

```bash
php artisan make:model NewModule
```

```php
// app/Models/NewModule.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

### Step 3: Create Controller

```bash
php artisan make:controller NewModuleController
```

```php
// app/Http/Controllers/NewModuleController.php
namespace App\Http\Controllers;

use App\Models\NewModule;
use Illuminate\Http\Request;

class NewModuleController extends Controller
{
    public function index(Request $request)
    {
        $modules = NewModule::where('user_id', $request->user()->id)->paginate(15);
        return view('new-modules.index', compact('modules'));
    }

    public function create()
    {
        return view('new-modules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $request->user()->newModules()->create($validated);

        return redirect()
            ->route('new-modules.index')
            ->with('success', 'Module created successfully.');
    }
}
```

### Step 4: Add Routes

```php
// routes/web.php
Route::middleware(['auth', 'module:new_module'])->group(function () {
    Route::resource('new-modules', NewModuleController::class);
});
```

### Step 5: Create Views

Create Blade templates in `resources/views/new-modules/`:

```blade
<!-- resources/views/new-modules/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-body border-0 py-3">
            <h2 class="h5 mb-1">New Modules</h2>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($modules as $module)
                        <tr>
                            <td>{{ $module->title }}</td>
                            <td>{{ $module->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('new-modules.show', $module) }}" class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-5">No modules found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
```

### Step 6: Add Module Control

```php
// app/Services/ModuleService.php
public function enabled(string $key): bool
{
    $enabled = $this->settingService->get("module.{$key}", '1');
    
    return $enabled === '1' || $enabled === 'true';
}

// Add to list of known modules
public function all(): array
{
    return [
        'suppliers' => 'Supplier Module',
        'products' => 'Product Management',
        'orders' => 'Order Management',
        'crm' => 'CRM',
        'marketing' => 'Marketing',
        'workflow' => 'Automation Engine',
        'social' => 'Social Media',
        'inventory' => 'Inventory',
        'support' => 'Support Ticket',
        'new_module' => 'New Module',  // Add here
    ];
}
```

---

## Adding Automation Events

### Step 1: Register Event in AutomationService

```php
// app/Services/AutomationService.php
public function run(string $event, mixed $payload = null): void
{
    // ... existing code ...
    
    $context = $this->buildContext($payload, $event);
    
    // ... existing code ...
}

private function buildContext(mixed $payload, string $event): array
{
    // ... existing cases ...
    
    if ($event === 'new_event' && $payload instanceof SomeModel) {
        return $context + [
            'custom_id' => $payload->id,
            'custom_field' => $payload->field,
        ];
    }
    
    // ... existing default ...
}
```

### Step 2: Add Event Constant to Model

```php
// app/Models/AutomationRule.php
class AutomationRule extends Model
{
    public const EVENT_NEW_EVENT = 'new_event';
    
    public static function events(): array
    {
        return [
            self::EVENT_ORDER_PLACED,
            self::EVENT_RFQ_CREATED,
            self::EVENT_STOCK_LOW,
            self::EVENT_NEW_EVENT,  // Add here
        ];
    }
}
```

### Step 3: Trigger the Event

```php
// In your controller or service
app(\App\Services\AutomationService::class)->run('new_event', $model);
```

---

## Custom Middleware

### Role Middleware

```php
// app/Http/Middleware/EnsureRole.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
        
        if (!$user || !$user->hasAnyRole($roles)) {
            abort(403, 'This action is unauthorized.');
        }
        
        return $next($request);
    }
}
```

### Module Middleware

```php
// app/Http/Middleware/EnsureModuleEnabled.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureModuleEnabled
{
    public function handle(Request $request, Closure $next, string $module)
    {
        if (!app(\App\Services\ModuleService::class)->enabled($module)) {
            abort(403, 'This module is currently disabled.');
        }
        
        return $next($request);
    }
}
```

---

## Testing

### Unit Tests

```php
// tests/Unit/Services/AutomationServiceTest.php
namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\AutomationRule;
use App\Models\Order;
use App\Services\AutomationService;

class AutomationServiceTest extends TestCase
{
    public function test_order_placed_event_triggers_rule(): void
    {
        $rule = AutomationRule::create([
            'name' => 'Test rule',
            'event' => AutomationRule::EVENT_ORDER_PLACED,
            'action' => AutomationRule::ACTION_LOG_ONLY,
            'is_active' => true,
        ]);

        $order = Order::create([
            'customer_id' => 1,
            'order_number' => 'TEST-001',
            'grand_total' => 100,
        ]);

        $service = new AutomationService();
        $service->run(AutomationRule::EVENT_ORDER_PLACED, $order);

        $this->assertEquals(1, $service->logs()->count());
    }
}
```

### Feature Tests

```php
// tests/Feature/OrderControllerTest.php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;
use App\Models\Order;

class OrderControllerTest extends TestCase
{
    public function test_customer_can_view_orders(): void
    {
        $user = User::factory()->create(['role_id' => 3]); // buyer role
        $customer = Customer::create(['user_id' => $user->id]);
        Order::factory()->count(3)->create(['customer_id' => $customer->id]);

        $response = $this->actingAs($user)->get('/orders');
        
        $response->assertStatus(200);
        $response->assertSee('Order #');
    }
}
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter OrderControllerTest

# Run with coverage
php artisan test --coverage
```

---

## Customizing Email Templates

### Customer Workflow Email

```blade
<!-- resources/views/emails/customer.blade.php -->
@component('mail::message')
# {{ $subject }}

{{ $body }}

@component('mail::panel')
@foreach ($meta as $label => $value)
- **{{ $label }}:** {{ $value }}
@endforeach
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
```

### Supplier Workflow Email

```blade
<!-- resources/views/emails/supplier.blade.php -->
@component('mail::message')
# {{ $subject }}

{{ $body }}

Order Details:
@foreach ($meta as $label => $value)
- **{{ $label }}:** {{ $value }}
@endforeach

Please log in to your dashboard for more details.

@component('mail::button', ['url' => config('app.url')])
View Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
```

---

## Debugging Tools

### Logging

```php
// Log with context
\Log::info('Automation rule executed', [
    'rule_id' => $rule->id,
    'order_id' => $order->id,
    'customer_id' => $order->customer_id,
]);

// Log error
\Log::error('Automation failed', [
    'rule_id' => $rule->id,
    'error' => $exception->getMessage(),
]);
```

### Queue Monitoring

```bash
# List queued jobs
php artisan queue:table

# Retry failed jobs
php artisan queue:retry all

# Flush failed jobs
php artisan queue:flush
```

### SQL Logging

```php
// Enable query logging
DB::enableQueryLog();

// View queries
dd(DB::getQueryLog());
```

---

## Environment-Specific Configuration

### Local Development

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=single
LOG_DEPRECATIONS_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=plexora_local
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database
SESSION_DRIVER=database

MAIL_MAILER=log
```

### Production

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=plexora
DB_USERNAME=plexora
DB_PASSWORD=strong_password

QUEUE_CONNECTION=database
SESSION_DRIVER=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
```

---

## Performance Optimization

### Configuration Caching

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

### Database Optimization

```sql
-- Add indexes for frequently queried columns
ALTER TABLE automation_rules ADD INDEX idx_event_active (event, is_active);
ALTER TABLE campaigns ADD INDEX idx_status_scheduled (status, scheduled_at);
ALTER TABLE support_tickets ADD INDEX idx_status_priority (status, priority);
```

### Queue Optimization

```bash
# Run multiple workers
php artisan queue:work --queue=automation --timeout=60 --max-jobs=1000

# Use Redis for better performance (optional)
# Install: composer require illuminate/redis
```

---

## Security Best Practices

### Input Validation

```php
// Always validate user input
$validated = $request->validate([
    'email' => 'required|email|max:255',
    'message' => 'required|string|max:1000',
    'price' => 'required|numeric|min:0',
]);
```

### Authorization Checks

```php
// Check user permissions
abort_unless($request->user()->hasRole('admin'), 403);

// Authorize specific action
abort_unless($user->can('update', $order), 403);
```

### XSS Prevention

```blade
<!-- Blade auto-escapes by default -->
{{ $userInput }}  <!-- Safe -->

<!-- For raw HTML, use e() function -->
{!! e($rawHtml) !!}  <!-- Safe -->
```

### SQL Injection Prevention

```php
// Use Eloquent (safe)
Order::where('id', $id)->first();

// Never use raw queries with user input
// DB::select("SELECT * FROM orders WHERE id = $id");  // UNSAFE
```

---

## Support

For technical support, contact: support@plexora.com

**Version:** 1.0.0  
**Last Updated:** May 2026
