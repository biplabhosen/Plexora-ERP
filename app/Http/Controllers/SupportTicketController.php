<?php

namespace App\Http\Controllers;

use App\Http\Requests\Support\StoreSupportTicketRequest;
use App\Models\Order;
use App\Models\SupportTicket;
use App\Models\Supplier;
use App\Services\SupportService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SupportTicketController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $query = SupportTicket::query()
            ->with(['customer', 'supplier', 'assignee'])
            ->latest();

        if ($user?->hasRole('supplier')) {
            $supplier = $user->supplier;
            abort_if($supplier?->status !== 'approved', 403, 'Approved supplier account required.');

            $query->where('supplier_id', $supplier->id);
        } elseif (! $user?->hasRole('admin') && ! $user?->hasRole('support_agent')) {
            $query->whereHas('customer', function (Builder $builder) use ($user): void {
                $builder->where('user_id', $user?->id);
            });
        }

        return view('support.index', [
            'tickets' => $query->paginate(10)->withQueryString(),
        ]);
    }

    public function create(Request $request): View
    {
        $user = $request->user();

        $orders = Order::query()
            ->with('customer')
            ->when(
                ! $user?->hasRole('admin') && ! $user?->hasRole('support_agent'),
                fn (Builder $builder) => $builder->whereHas('customer', fn (Builder $customerQuery) => $customerQuery->where('user_id', $user?->id))
            )
            ->latest()
            ->get();

        $suppliers = Supplier::query()
            ->when(
                $user?->hasRole('supplier'),
                fn (Builder $builder) => $builder->whereKey($user?->supplier?->id ?? 0),
                fn (Builder $builder) => $builder->where('status', 'approved')
            )
            ->orderBy('company_name')
            ->get();

        return view('support.create', [
            'orders' => $orders,
            'suppliers' => $suppliers,
            'categories' => [
                SupportTicket::CATEGORY_ORDER,
                SupportTicket::CATEGORY_PAYMENT,
                SupportTicket::CATEGORY_DELIVERY,
                SupportTicket::CATEGORY_SUPPLIER,
                SupportTicket::CATEGORY_GENERAL,
            ],
            'priorities' => [
                SupportTicket::PRIORITY_LOW,
                SupportTicket::PRIORITY_MEDIUM,
                SupportTicket::PRIORITY_HIGH,
                SupportTicket::PRIORITY_URGENT,
            ],
        ]);
    }

    public function store(StoreSupportTicketRequest $request, SupportService $supportService): RedirectResponse
    {
        $ticket = $supportService->createTicket($request->validated(), $request->user());

        return redirect()
            ->route('support-tickets.show', $ticket)
            ->with('success', 'Support ticket created successfully.');
    }

    public function show(SupportTicket $supportTicket, Request $request): View
    {
        $this->authorizeView($supportTicket, $request->user());

        $supportTicket->load([
            'customer.user',
            'order.customer',
            'supplier.user',
            'assignee',
            'replies' => fn ($query) => $query->with('author')->latest(),
        ]);

        return view('support.show', [
            'ticket' => $supportTicket,
            'canChangeStatus' => $request->user()?->hasRole('admin') || $request->user()?->hasRole('support_agent'),
        ]);
    }

    public function updateStatus(Request $request, SupportTicket $supportTicket, SupportService $supportService): RedirectResponse
    {
        abort_unless($request->user()?->hasRole('admin') || $request->user()?->hasRole('support_agent'), 403);

        $validated = $request->validate([
            'status' => ['required', Rule::in([
                SupportTicket::STATUS_OPEN,
                SupportTicket::STATUS_PENDING,
                SupportTicket::STATUS_RESOLVED,
                SupportTicket::STATUS_CLOSED,
            ])],
        ]);

        $supportService->changeStatus($supportTicket, $validated['status'], $request->user());

        return redirect()
            ->route('support-tickets.show', $supportTicket)
            ->with('success', 'Ticket status updated successfully.');
    }

    private function authorizeView(SupportTicket $ticket, $user): void
    {
        if ($user?->hasRole('admin') || $user?->hasRole('support_agent')) {
            return;
        }

        if ($user?->hasRole('supplier')) {
            abort_unless($ticket->supplier_id === $user->supplier?->id, 403);

            return;
        }

        abort_unless($ticket->customer?->user_id === $user?->id, 403);
    }
}
