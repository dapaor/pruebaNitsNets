<?php

namespace App\Http\Requests\Socio;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSocioRequest extends FormRequest
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
            'socio.nombre' => 'required|max:50',
            'socio.apellidos' => 'required|max:100',
            'socio.dni' => 'required|max:50|unique:socios,dni',
            'socio.email' => 'required|email|unique:socios,email|max:100',
            'socio.contrasena' => 'required|max:100'
        ];
    }

    public function attributes():array
    {
        return [
            'socio.nombre' => 'nombre',
            'socio.apellidos' => 'apellidos',
            'socio.dni' => 'dni',
            'socio.email' => 'correo electrónico',
            'socio.contrasena' => 'contrasena'
        ];
    }

    public function messages():array
    {
        return [
            'socio.nombre.required' => 'El :attribute es necesario para registrar un socio',
            'socio.nombre.max' => 'El :attribute debe tener como máximo 50 caracteres',

            'socio.apellidos.required' => 'El :attribute es necesario para registrar un socio',
            'socio.apellidos.max' => 'El :attribute debe tener como máximo 50 caracteres',

            'socio.contrasena.required' => 'El :attribute es necesario para registrar un socio',
            'socio.contrasena.max' => 'El :attribute debe tener como máximo 50 caracteres',

            'socio.dni.required' => 'El :attribute es necesario para registrar un socio',
            'socio.dni.max' => 'El :attribute debe tener como máximo 50 caracteres',
            'socio.dni.unique' => 'El :attribute ya existe en la base de datos',

            'socio.email.required' => 'El :attribute es necesario para registrar un socio',
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
