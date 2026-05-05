<?php

use App\Events\StockLow;
use App\Models\Product;
use App\Models\WorkflowLog;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function (): void {
    Product::query()
        ->with('supplier.user')
        ->whereHas('supplier', fn ($query) => $query->where('status', 'approved'))
        ->lowStock()
        ->chunkById(100, function ($products): void {
            foreach ($products as $product) {
                event(new StockLow($product));
            }
        });
})->everyMinute()->name('automation:check-low-stock')->withoutOverlapping();

Schedule::call(function (): void {
    WorkflowLog::query()
        ->where('created_at', '<', now()->subDays(30))
        ->delete();
})->dailyAt('01:00')->name('automation:prune-workflow-logs');

Schedule::call(function (): void {
    Log::info('Workflow automation summary placeholder report executed.');
})->hourly()->name('automation:summary-report');
