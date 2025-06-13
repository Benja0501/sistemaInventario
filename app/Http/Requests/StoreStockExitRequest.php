<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Product;

class StoreStockExitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            // El tipo de salida, basado en los casos de uso
            'type' => ['required', Rule::in(['Waste', 'Discrepancy Adjustment', 'Other'])],
            'reason' => 'nullable|string|max:255',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Si la validación inicial falla, no continuamos.
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            // Buscamos el producto en la base de datos
            $product = Product::find($this->input('product_id'));
            $quantityToExit = (int)$this->input('quantity');

            // Verificamos si hay stock suficiente
            if ($product->stock < $quantityToExit) {
                // Si no hay stock, añadimos un error específico al campo 'quantity'.
                $validator->errors()->add(
                    'quantity',
                    "No hay stock suficiente. Stock actual: {$product->stock}"
                );
            }
        });
    }
}
