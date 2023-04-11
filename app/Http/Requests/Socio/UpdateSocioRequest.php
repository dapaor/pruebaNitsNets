<?php

namespace App\Http\Requests\Socio;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateSocioRequest extends FormRequest
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
            'socio.dni' => ['max:50|unique:socios,dni'],
            'socio.nombre' => 'max:50',
            'socio.apellidos' => 'max:100',
            'socio.email' => 'email|max:100|unique:socios,email',
            'socio.contrasena' => 'max:100'
        ];
    }

    public function attributes()
    {
        return [
            'socio.dni' => 'DNI',
            'socio.nombre' => 'nombre',
            'socio.apellidos' => 'apellidos',
            'socio.email' => 'email',
            'socio.contrasena' => 'contraseña'
        ];
    }

    public function messages():array
    {
        return [
            'socio.nombre.max' => 'El :attribute debe tener como máximo 50 caracteres',

            'socio.apellidos.max' => 'El :attribute debe tener como máximo 50 caracteres',

            'socio.contrasena.max' => 'El :attribute debe tener como máximo 50 caracteres',

            'socio.dni.max' => 'El :attribute debe tener como máximo 50 caracteres',
            'socio.dni.unique' => 'El :attribute ya existe en la base de datos',

            'socio.email.max' => 'El :attribute debe tener como máximo 50 caracteres',
            'socio.email.unique' => 'El :attribute ya existe en la base de datos',
            'socio.email.email' => 'El :attribute debe ser una dirección válida de email'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
