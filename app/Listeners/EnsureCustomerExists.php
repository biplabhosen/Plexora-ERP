<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Services\CustomerService;

class EnsureCustomerExists
{
    public function __construct(
        private readonly CustomerService $customerService,
    ) {
    }

    public function handle(OrderPlaced $event): void
    {
        if ($event->order->customer) {
            return;
        }

        $customer = $this->customerService->ensureCustomerExists($event->user);

        $event->order->forceFill([
            'customer_id' => $customer->id,
        ])->save();
    }
}
