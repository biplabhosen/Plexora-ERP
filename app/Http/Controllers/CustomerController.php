<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerNoteRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Rfq;
use App\Services\CustomerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(
        private readonly CustomerService $customerService,
    ) {
    }

    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $customers = Customer::query()
            ->with('user:id,name,email')
            ->withCount('orders')
            ->withSum('orders', 'grand_total')
            ->withMax('orders', 'created_at')
            ->search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $customers->getCollection()->transform(function (Customer $customer): Customer {
            $customer->segment = $this->customerService->getSegment($customer);

            return $customer;
        });

        return view('customers.index', [
            'customers' => $customers,
            'search' => $search,
        ]);
    }

    public function show(Customer $customer): View
    {
        $customer->load('user:id,name,email');

        $orders = Order::query()
            ->where('customer_id', $customer->id)
            ->with('items.product')
            ->latest()
            ->paginate(5, ['*'], 'orders_page');

        $rfqs = Rfq::query()
            ->where('buyer_id', $customer->user_id)
            ->with(['buyer:id,name,email', 'supplier:id,company_name'])
            ->latest()
            ->paginate(5, ['*'], 'rfqs_page');

        $notes = $customer->notes()
            ->with('author:id,name')
            ->latest()
            ->paginate(5, ['*'], 'notes_page');

        $kpis = [
            'total_orders' => Order::query()->where('customer_id', $customer->id)->count(),
            'total_spent' => (float) Order::query()->where('customer_id', $customer->id)->sum('grand_total'),
            'avg_order_value' => (float) (Order::query()->where('customer_id', $customer->id)->avg('grand_total') ?? 0),
            'last_order_date' => Order::query()->where('customer_id', $customer->id)->max('created_at'),
        ];

        return view('customers.show', [
            'customer' => $customer,
            'orders' => $orders,
            'rfqs' => $rfqs,
            'notes' => $notes,
            'segment' => $this->customerService->getSegment($customer->loadMissing('orders')),
            'kpis' => $kpis,
        ]);
    }

    public function storeNote(StoreCustomerNoteRequest $request, Customer $customer): RedirectResponse
    {
        $customer->notes()->create([
            'user_id' => $request->user()->id,
            'note' => $request->validated('note'),
        ]);

        return redirect()
            ->route('customers.show', $customer)
            ->with('success', 'Customer note added successfully.');
    }
}
