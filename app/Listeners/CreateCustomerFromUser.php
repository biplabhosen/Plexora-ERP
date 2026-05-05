<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\Campaign;
use App\Services\CampaignService;
use App\Services\CustomerService;

class CreateCustomerFromUser
{
    public function __construct(
        private readonly CustomerService $customerService,
        private readonly CampaignService $campaignService,
    ) {
    }

    public function handle(UserRegistered $event): void
    {
        if (! in_array($event->user->role?->name, ['user', 'buyer', 'customer'], true)) {
            return;
        }

        $this->customerService->ensureCustomerExists($event->user);
        $this->campaignService->dispatchTriggeredCampaigns(Campaign::TRIGGER_CUSTOMER_REGISTERED, $event->user);
    }
}
