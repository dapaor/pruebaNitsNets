<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'user.email' => 'required|email|exists:users,email',
            'user.password' => 'required'
        ];
    }

    public function attributes() : array
    {
        return [
            'user.email' => 'correo electrónico del usuario',
            'user.password' => 'contraseña'
        ];
    }
    public function messages() : array
    {
        return [
            'user.email.required' => 'El :attribute es necesario para el registro del usuario',
            'user.email.email' => 'El :attribute debe tener un formato de email correcto (example@example.test)',
            'user.email.exists' => 'El :attribute no está registrado en la aplicación',
            'user.password.required' => 'La :attribute es necesaria para el registro del usuario',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
