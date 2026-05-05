<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Events\RfqCreated;
use App\Events\StockLow;
use App\Models\AutomationRule;
use App\Services\AutomationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RunAutomationRules implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly AutomationService $automationService
    ) {}

    public function handle(OrderPlaced|RfqCreated|StockLow $event): void
    {
        $eventName = match (true) {
            $event instanceof OrderPlaced => AutomationRule::EVENT_ORDER_PLACED,
            $event instanceof RfqCreated => AutomationRule::EVENT_RFQ_CREATED,
            $event instanceof StockLow => AutomationRule::EVENT_STOCK_LOW,
        };

        $payload = match (true) {
            $event instanceof OrderPlaced => $event->order,
            $event instanceof RfqCreated => $event->rfq,
            $event instanceof StockLow => $event->product,
        };

        $this->automationService->run($eventName, $payload);
    }
}
