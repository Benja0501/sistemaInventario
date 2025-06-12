<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        // El ID del usuario se obtiene del parámetro de la ruta
        $userId = $this->route('usuario')->id;
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            // La contraseña es opcional al actualizar. Solo se valida si se envía.
            'password' => 'nullable|string|confirmed|min:8',
            'role' => ['required', Rule::in(['supervisor', 'purchasing', 'warehouse'])],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }
}
