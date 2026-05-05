<?php

namespace App\Http\Controllers;

use App\Http\Requests\Support\StoreSupportReplyRequest;
use App\Models\SupportTicket;
use App\Services\SupportService;
use Illuminate\Http\RedirectResponse;

class SupportReplyController extends Controller
{
    public function store(StoreSupportReplyRequest $request, SupportTicket $supportTicket, SupportService $supportService): RedirectResponse
    {
        $user = $request->user();

        $canReply = $user?->hasRole('admin')
            || $user?->hasRole('support_agent')
            || ($user?->hasRole('supplier') && $supportTicket->supplier_id === $user->supplier?->id)
            || ($supportTicket->customer?->user_id === $user?->id);

        abort_unless($canReply, 403);

        $supportService->createReply($supportTicket, $user, $request->validated('message'));

        return redirect()
            ->route('support-tickets.show', $supportTicket)
            ->with('success', 'Reply added successfully.');
    }
}
