<?php

namespace App\Providers;

use App\Events\OrderConfirmed;
use App\Events\OrderPlaced;
use App\Events\RfqCreated;
use App\Events\StockLow;
use App\Events\SupportTicketCreated;
use App\Events\UserRegistered;
use App\Services\ModuleService;
use App\Listeners\CreateCustomerFromUser;
use App\Listeners\EnsureCustomerExists;
use App\Listeners\RunAutomationRules;
use App\Listeners\RunSupportAutomation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('moduleEnabled', fn (string $key): bool => app(ModuleService::class)->enabled($key));

        // Event::listen(UserRegistered::class, CreateCustomerFromUser::class);
        // Event::listen(OrderPlaced::class, EnsureCustomerExists::class);
        // Event::listen(OrderPlaced::class, RunAutomationRules::class);
        // Event::listen(OrderConfirmed::class, RunSupportAutomation::class);
        // Event::listen(RfqCreated::class, RunAutomationRules::class);
        // Event::listen(StockLow::class, RunAutomationRules::class);
        // Event::listen(SupportTicketCreated::class, RunSupportAutomation::class);
    }
}
