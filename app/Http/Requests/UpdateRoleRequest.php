<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
        // Obtenemos el ID del rol desde la ruta: /roles/{role}
        $roleId = $this->route('role')->id;

        return [
            'name'        => 'required|string|unique:roles,name,' . $roleId . '|max:100',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ];
    }
}
