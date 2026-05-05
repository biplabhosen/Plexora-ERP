<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'supplier', 'user', 'marketing_manager', 'support_agent'] as $role) {
            Role::query()->firstOrCreate(['name' => $role]);
        }
    }
}
