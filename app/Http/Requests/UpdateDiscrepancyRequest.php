<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscrepancyRequest extends FormRequest
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
            'product_id'          => 'required|exists:products,id',
            'system_quantity'     => 'required|integer|min:0',
            'physical_quantity'   => 'required|integer|min:0',
            'discrepancy_type'    => 'required|string|in:shortage,overstock,damaged,other',
            'note'                => 'nullable|string|max:1000',
            'evidence_path'       => 'nullable|string|max:255',
            'reported_by_user_id' => 'required|exists:users,id',
            'reported_at'         => 'required|date',
        ];
    }
}
