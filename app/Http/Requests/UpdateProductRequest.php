<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        $id = $this->route('product')->id;

        return [
            'sku'             => "required|string|max:100|unique:products,sku,{$id}",
            'name'            => 'required|string|max:150',
            'description'     => 'nullable|string',
            'unit_price'      => 'required|numeric|min:0',
            'min_stock'       => 'required|integer|min:0',
            'current_stock'   => 'required|integer|min:0',
            'unit_of_measure' => 'required|string|max:50',
            'category_id'     => 'required|exists:categories,id',
            'status'          => 'required|in:active,inactive',
        ];
    }
}
