<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseOrderRequest extends FormRequest
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
        $id = $this->route('purchase_order')->id;

        return [
            'order_number'            => "required|string|max:50|unique:purchase_orders,order_number,{$id}",
            'created_by_user_id'      => 'required|exists:users,id',
            'supplier_id'             => 'required|exists:suppliers,id',
            'order_date'              => 'required|date',
            'expected_delivery_date'  => 'nullable|date|after_or_equal:order_date',
            'total_amount'            => 'required|numeric|min:0',
            'status'                  => 'required|in:pending,approved,rejected,sent,partial_received,completed,canceled',
        ];
    }
}
