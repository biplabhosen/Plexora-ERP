<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Role;
use App\Models\SupportTicket;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SupportSeeder extends Seeder
{
    public function run(): void
    {
        $buyerRole = Role::query()->firstOrCreate(['name' => 'user']);
        $supplierRole = Role::query()->firstOrCreate(['name' => 'supplier']);

        $buyer = User::query()->firstOrCreate(
            ['email' => 'buyer.support@example.com'],
            [
                'name' => 'Support Buyer',
                'password' => Hash::make('password'),
                'role_id' => $buyerRole->id,
            ]
        );

        if (! $buyer->role_id) {
            $buyer->update(['role_id' => $buyerRole->id]);
        }

        $customer = Customer::query()->firstOrCreate(
            ['user_id' => $buyer->id],
            [
                'name' => $buyer->name,
                'email' => $buyer->email,
                'phone' => '+8801700000000',
                'address' => 'Dhaka',
            ]
        );

        $supplierUser = User::query()->firstOrCreate(
            ['email' => 'supplier.support@example.com'],
            [
                'name' => 'Support Supplier',
                'password' => Hash::make('password'),
                'role_id' => $supplierRole->id,
            ]
        );

        if (! $supplierUser->role_id) {
            $supplierUser->update(['role_id' => $supplierRole->id]);
        }

        $supplier = Supplier::query()->firstOrCreate(
            ['user_id' => $supplierUser->id],
            [
                'company_name' => 'Acme Fulfillment Ltd.',
                'contact_person' => 'Support Supplier',
                'phone' => '+8801800000000',
                'email' => $supplierUser->email,
                'address' => 'Chattogram',
                'business_type' => 'Wholesale',
                'trade_license' => 'TL-2026-ACME',
                'status' => 'approved',
                'approved_at' => now(),
            ]
        );

        $order = Order::query()->firstOrCreate(
            ['order_number' => 'ORD-SUPPORT-DEMO-001'],
            [
                'customer_id' => $customer->id,
                'subtotal' => '500.00',
                'discount' => '0.00',
                'tax' => '0.00',
                'grand_total' => '500.00',
                'status' => 'confirmed',
                'notes' => 'Sample order for support module seeding.',
            ]
        );

        $tickets = [
            [
                'subject' => 'Delivery delay on order shipment',
                'message' => 'My delivery is delayed and I need an updated expected delivery date.',
                'category' => SupportTicket::CATEGORY_DELIVERY,
                'priority' => SupportTicket::PRIORITY_HIGH,
                'status' => SupportTicket::STATUS_OPEN,
            ],
            [
                'subject' => 'Payment reflected twice',
                'message' => 'The payment gateway appears to have charged me twice for the same order.',
                'category' => SupportTicket::CATEGORY_PAYMENT,
                'priority' => SupportTicket::PRIORITY_URGENT,
                'status' => SupportTicket::STATUS_PENDING,
            ],
            [
                'subject' => 'Supplier quality complaint',
                'message' => 'The supplier shipment did not match the approved product specification.',
                'category' => SupportTicket::CATEGORY_SUPPLIER,
                'priority' => SupportTicket::PRIORITY_MEDIUM,
                'status' => SupportTicket::STATUS_OPEN,
            ],
        ];

        foreach ($tickets as $index => $ticketData) {
            $ticket = SupportTicket::query()->firstOrCreate(
                ['subject' => $ticketData['subject']],
                $ticketData + [
                    'customer_id' => $customer->id,
                    'order_id' => $order->id,
                    'supplier_id' => $index === 2 ? $supplier->id : null,
                ]
            );

            $ticket->replies()->firstOrCreate(
                [
                    'message' => 'Thank you. Your request has been received. Our team will contact you soon.',
                    'is_system' => true,
                ],
                ['user_id' => null]
            );
        }
    }
}
