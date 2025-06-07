<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $supplierId = $this->route('supplier')->id;
        return [
            'business_name' => 'required|string|max:150',
            'tax_id'        => 'required|string|max:50|unique:suppliers,tax_id,' . $supplierId,
            'address'       => 'nullable|string|max:500',
            'phone'         => 'nullable|string|max:50',
            'email'         => 'nullable|email|max:150',
            'status'        => 'required|in:active,inactive',
        ];
    }
}
