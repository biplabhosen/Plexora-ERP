<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_only_sees_their_own_orders(): void
    {
        $buyerRole = Role::create(['name' => 'user']);
        $buyer = User::factory()->create(['role_id' => $buyerRole->id]);
        $otherBuyer = User::factory()->create(['role_id' => $buyerRole->id]);

        $myOrder = Order::create([
            'customer_id' => $buyer->id,
            'order_number' => 'ORD-MINE-001',
            'subtotal' => '100.00',
            'discount' => '0.00',
            'tax' => '0.00',
            'grand_total' => '100.00',
            'status' => 'pending',
        ]);

        $otherOrder = Order::create([
            'customer_id' => $otherBuyer->id,
            'order_number' => 'ORD-OTHER-001',
            'subtotal' => '200.00',
            'discount' => '0.00',
            'tax' => '0.00',
            'grand_total' => '200.00',
            'status' => 'pending',
        ]);

        $this->actingAs($buyer)
            ->get(route('orders.index'))
            ->assertOk()
            ->assertSee($myOrder->order_number)
            ->assertDontSee($otherOrder->order_number);

        $this->actingAs($buyer)
            ->get(route('orders.show', $myOrder))
            ->assertOk();

        $this->actingAs($buyer)
            ->get(route('orders.show', $otherOrder))
            ->assertForbidden();
    }

    public function test_supplier_only_sees_orders_with_their_own_line_items(): void
    {
        $buyerRole = Role::create(['name' => 'user']);
        $supplierRole = Role::create(['name' => 'supplier']);

        $buyer = User::factory()->create(['role_id' => $buyerRole->id]);
        $supplierUser = User::factory()->create(['role_id' => $supplierRole->id]);
        $otherSupplierUser = User::factory()->create(['role_id' => $supplierRole->id]);

        $supplier = Supplier::create([
            'user_id' => $supplierUser->id,
            'company_name' => 'Alpha Supply',
            'contact_person' => 'Alpha Owner',
            'status' => 'approved',
        ]);

        $otherSupplier = Supplier::create([
            'user_id' => $otherSupplierUser->id,
            'company_name' => 'Beta Supply',
            'contact_person' => 'Beta Owner',
            'status' => 'approved',
        ]);

        $myProduct = Product::create([
            'supplier_id' => $supplier->id,
            'sku' => 'ALPHA-1',
            'name' => 'Alpha Product',
            'price' => '25.00',
            'stock' => 100,
            'moq' => 1,
            'status' => true,
        ]);

        $otherProduct = Product::create([
            'supplier_id' => $otherSupplier->id,
            'sku' => 'BETA-1',
            'name' => 'Beta Product',
            'price' => '40.00',
            'stock' => 100,
            'moq' => 1,
            'status' => true,
        ]);

        $mixedOrder = Order::create([
            'customer_id' => $buyer->id,
            'order_number' => 'ORD-MIXED-001',
            'subtotal' => '65.00',
            'discount' => '0.00',
            'tax' => '0.00',
            'grand_total' => '65.00',
            'status' => 'pending',
        ]);

        OrderItem::create([
            'order_id' => $mixedOrder->id,
            'product_id' => $myProduct->id,
            'price' => '25.00',
            'quantity' => 1,
            'line_total' => '25.00',
        ]);

        OrderItem::create([
            'order_id' => $mixedOrder->id,
            'product_id' => $otherProduct->id,
            'price' => '40.00',
            'quantity' => 1,
            'line_total' => '40.00',
        ]);

        $otherOrder = Order::create([
            'customer_id' => $buyer->id,
            'order_number' => 'ORD-BETA-ONLY',
            'subtotal' => '40.00',
            'discount' => '0.00',
            'tax' => '0.00',
            'grand_total' => '40.00',
            'status' => 'pending',
        ]);

        OrderItem::create([
            'order_id' => $otherOrder->id,
            'product_id' => $otherProduct->id,
            'price' => '40.00',
            'quantity' => 1,
            'line_total' => '40.00',
        ]);

        $this->actingAs($supplierUser)
            ->get(route('orders.index'))
            ->assertOk()
            ->assertSee($mixedOrder->order_number)
            ->assertDontSee($otherOrder->order_number);

        $this->actingAs($supplierUser)
            ->get(route('orders.show', $mixedOrder))
            ->assertOk()
            ->assertSee('Alpha Product')
            ->assertDontSee('Beta Product')
            ->assertSee('$25.00');

        $this->actingAs($supplierUser)
            ->get(route('orders.show', $otherOrder))
            ->assertForbidden();
    }
}
