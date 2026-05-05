<?php

namespace Database\Seeders;

use App\Models\AutomationRule;
use Illuminate\Database\Seeder;

class AutomationRuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            [
                'name' => 'Order placed email confirmation',
                'event' => AutomationRule::EVENT_ORDER_PLACED,
                'condition' => null,
                'action' => AutomationRule::ACTION_SEND_EMAIL,
                'target' => null,
                'is_active' => true,
            ],
            [
                'name' => 'RFQ created supplier notification',
                'event' => AutomationRule::EVENT_RFQ_CREATED,
                'condition' => null,
                'action' => AutomationRule::ACTION_NOTIFY_SUPPLIER,
                'target' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Low stock supplier notification',
                'event' => AutomationRule::EVENT_STOCK_LOW,
                'condition' => null,
                'action' => AutomationRule::ACTION_NOTIFY_SUPPLIER,
                'target' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Low stock unresolved admin escalation',
                'event' => AutomationRule::EVENT_STOCK_LOW,
                'condition' => 'unresolved_24h',
                'action' => AutomationRule::ACTION_NOTIFY_ADMIN,
                'target' => null,
                'is_active' => true,
            ],
        ];

        foreach ($rules as $rule) {
            AutomationRule::query()->updateOrCreate(
                ['name' => $rule['name']],
                $rule
            );
        }
    }
}
