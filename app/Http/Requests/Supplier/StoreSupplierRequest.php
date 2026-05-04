<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'company_name'   => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone'          => 'nullable|string|max:30',
            'email'          => 'nullable|email',
            'address'        => 'nullable|string',
            'business_type'  => 'nullable|string',
            'trade_license' => 'nullable|string',
        ];
    }
}
