<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Carbon;

class CustomerService
{
    public function ensureCustomerExists(User $user): Customer
    {
        return Customer::query()->firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => null,
            ]
        );
    }

    public function getSegment(Customer $customer): string
    {
        $totalSpent = $customer->orders_sum_grand_total !== null
            ? (float) $customer->orders_sum_grand_total
            : (float) ($customer->relationLoaded('orders') ? $customer->orders->sum('grand_total') : $customer->orders()->sum('grand_total'));

        $orderCount = $customer->orders_count !== null
            ? (int) $customer->orders_count
            : ($customer->relationLoaded('orders') ? $customer->orders->count() : $customer->orders()->count());

        $lastOrderAt = $customer->orders_max_created_at
            ?? ($customer->relationLoaded('orders') ? $customer->orders->max('created_at') : $customer->orders()->max('created_at'));

        if ($totalSpent >= 50000) {
            return 'VIP';
        }

        if ($orderCount >= 10) {
            return 'Frequent';
        }

        if ($customer->created_at?->gte(now()->subDays(30))) {
            return 'New';
        }

        if (! $lastOrderAt || Carbon::parse($lastOrderAt)->lt(now()->subDays(90))) {
            return 'Inactive';
        }

        return 'Regular';
    }
}
