<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\RfqCreated;
use App\Events\StockLow;
use App\Events\UserRegistered;
use App\Listeners\CreateCustomerFromUser;
use App\Listeners\EnsureCustomerExists;
use App\Listeners\RunAutomationRules;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(UserRegistered::class, CreateCustomerFromUser::class);
        Event::listen(OrderPlaced::class, EnsureCustomerExists::class);
        Event::listen(OrderPlaced::class, RunAutomationRules::class);
        Event::listen(RfqCreated::class, RunAutomationRules::class);
        Event::listen(StockLow::class, RunAutomationRules::class);
    }
}
