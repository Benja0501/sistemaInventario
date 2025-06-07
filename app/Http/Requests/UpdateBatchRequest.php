<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBatchRequest extends FormRequest
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
        $id = $this->route('batch')->id;

        return [
            'product_id'      => 'required|exists:products,id',
            'batch_number'    => "required|string|max:100|unique:batches,batch_number,{$id}",
            'expiration_date' => 'nullable|date|after_or_equal:today',
            'quantity'        => 'required|integer|min:0',
        ];
    }
}
