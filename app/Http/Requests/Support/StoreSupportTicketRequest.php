<?php

namespace App\Http\Requests\Support;

use App\Models\SupportTicket;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSupportTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'order_id' => ['nullable', 'exists:orders,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'category' => ['required', Rule::in([
                SupportTicket::CATEGORY_ORDER,
                SupportTicket::CATEGORY_PAYMENT,
                SupportTicket::CATEGORY_DELIVERY,
                SupportTicket::CATEGORY_SUPPLIER,
                SupportTicket::CATEGORY_GENERAL,
            ])],
            'priority' => ['required', Rule::in([
                SupportTicket::PRIORITY_LOW,
                SupportTicket::PRIORITY_MEDIUM,
                SupportTicket::PRIORITY_HIGH,
                SupportTicket::PRIORITY_URGENT,
            ])],
        ];
    }
}
