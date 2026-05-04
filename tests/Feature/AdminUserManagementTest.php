<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_user_management_page(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $buyer = User::factory()->create([
            'role_id' => $userRole->id,
            'name' => 'Buyer Account',
            'email' => 'buyer@example.com',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Users')
            ->assertSee($buyer->name)
            ->assertSee($buyer->email);
    }

    public function test_non_admin_cannot_access_user_management_page(): void
    {
        $userRole = Role::create(['name' => 'user']);
        $buyer = User::factory()->create(['role_id' => $userRole->id]);

        $this->actingAs($buyer)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public function test_admin_can_update_user_role(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $buyer = User::factory()->create([
            'role_id' => $userRole->id,
            'name' => 'Old Buyer',
            'email' => 'oldbuyer@example.com',
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('admin.users.update', $buyer), [
                'name' => 'Updated Buyer',
                'email' => 'updatedbuyer@example.com',
                'role_id' => $adminRole->id,
            ]);

        $response->assertRedirect(route('admin.users.index'));

        $buyer->refresh();

        $this->assertSame('Updated Buyer', $buyer->name);
        $this->assertSame('updatedbuyer@example.com', $buyer->email);
        $this->assertSame($adminRole->id, $buyer->role_id);
    }
}
