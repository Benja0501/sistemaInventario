<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'minimum_stock' => 'required|integer|min:0',
            'status' => ['required', Rule::in(['active', 'discontinued', 'inactive'])],
            'purchase_price' => 'nullable|numeric|min:0|max:99999999.99',
            'sale_price' => 'required|numeric|min:0|max:99999999.99',
        ];
    }
}
