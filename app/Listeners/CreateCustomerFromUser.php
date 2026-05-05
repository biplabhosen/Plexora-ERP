<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Services\CustomerService;

class CreateCustomerFromUser
{
    public function __construct(
        private readonly CustomerService $customerService,
    ) {
    }

    public function handle(UserRegistered $event): void
    {
        if (! in_array($event->user->role?->name, ['user', 'buyer', 'customer'], true)) {
            return;
        }

        $this->customerService->ensureCustomerExists($event->user);
    }
}
