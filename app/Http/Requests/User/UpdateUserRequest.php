<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user.name' => 'string|max:50',
            'user.email' => 'string|email|unique:users,email|max:100',
            'user.password' => 'string|max:100|min:8'
        ];
    }

    public function attributes() : array
    {
        return [
            'user.name' => 'nombre del usuario',
            'user.email' => 'correo electrónico del usuario',
            'user.password' => 'contraseña'
        ];
    }
    public function messages() : array
    {
        return [
            'user.name.max' => 'El :attribute no puede exceder los 50 caracteres de tamaño',
            'user.email.email' => 'El :attribute debe tener un formato de email correcto (example@example.test)',
            'user.email.unique' => 'El :attribute ya se encuentra registrado en la aplicación',
            'user.email.max' => 'El :attribute no puede exceder los 100 caracteres de longitud',
            'user.password.max' => 'La :attribute no puede exceder los 100 caracteres de longitud',
            'user.password.min' => 'La :attribute debe tener un mínimo de 8 caracteres'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
