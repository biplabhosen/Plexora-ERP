<?php

namespace App\Http\Requests\Automation;

use App\Models\AutomationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAutomationRuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin') ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'event' => ['required', Rule::in([
                AutomationRule::EVENT_ORDER_PLACED,
                AutomationRule::EVENT_RFQ_CREATED,
                AutomationRule::EVENT_STOCK_LOW,
            ])],
            'action' => ['required', Rule::in([
                AutomationRule::ACTION_SEND_EMAIL,
                AutomationRule::ACTION_NOTIFY_SUPPLIER,
                AutomationRule::ACTION_NOTIFY_ADMIN,
                AutomationRule::ACTION_LOG_ONLY,
            ])],
            'condition' => ['nullable', 'string', 'max:255'],
            'target' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
