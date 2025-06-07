<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceptionRequest extends FormRequest
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
        return [
            'purchase_order_id'     => 'required|exists:purchase_orders,id',
            'received_by_user_id'   => 'required|exists:users,id',
            'received_at'           => 'required|date',
            'status'                => 'required|in:pending,completed,canceled',
        ];
    }
}
