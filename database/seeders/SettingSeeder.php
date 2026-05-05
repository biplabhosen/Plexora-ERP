<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'module_products' => '1',
            'module_inventory' => '1',
            'module_orders' => '1',
            'module_crm' => '1',
            'module_rfq' => '1',
            'module_workflow' => '1',
            'module_marketing' => '1',
            'module_social' => '1',
            'module_support' => '1',
            'module_suppliers' => '1',
        ];

        foreach ($settings as $key => $value) {
            Setting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
