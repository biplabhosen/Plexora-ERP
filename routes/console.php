<?php

use App\Jobs\RunScheduledCampaignJob;
use App\Events\StockLow;
use App\Models\CampaignLog;
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

Schedule::job(new RunScheduledCampaignJob())
    ->everyMinute()
    ->name('campaigns:run-scheduled')
    ->withoutOverlapping();

// Shared hosting usually cannot keep a long-running queue worker alive.
// This scheduled worker drains pending jobs each minute and then exits.
Schedule::command('queue:work', [
    '--queue' => 'default,automation,campaigns,support',
    '--stop-when-empty' => true,
    '--tries' => 3,
    '--timeout' => 120,
    '--sleep' => 1,
    '--max-time' => 50,
])
    ->everyMinute()
    ->name('queues:drain-shared-hosting')
    ->withoutOverlapping();

Schedule::call(function (): void {
    WorkflowLog::query()
        ->where('created_at', '<', now()->subDays(30))
        ->delete();
})->dailyAt('01:00')->name('automation:prune-workflow-logs');

Schedule::call(function (): void {
    CampaignLog::query()
        ->where('created_at', '<', now()->subDays(90))
        ->delete();
})->dailyAt('01:15')->name('campaigns:prune-logs');

Schedule::call(function (): void {
    Log::info('Daily campaign summary generated.', [
        'sent_today' => CampaignLog::query()
            ->whereDate('created_at', today())
            ->where('status', 'sent')
            ->count(),
        'failed_today' => CampaignLog::query()
            ->whereDate('created_at', today())
            ->where('status', 'failed')
            ->count(),
        'scheduled_due_tomorrow' => \App\Models\Campaign::query()
            ->whereBetween('scheduled_at', [now(), now()->addDay()])
            ->count(),
    ]);
})->dailyAt('08:00')->name('campaigns:daily-summary');
