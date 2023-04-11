<?php

namespace App\Http\Requests\Deporte;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreDeporteRequest extends FormRequest
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
            'deporte.name' => 'required|max:50|unique:deportes,name',
            'deporte.codigo' => 'required|max:4|unique:deportes,codigo'
        ];
    }

    public function messages(): array
    {
        return [
            'deporte.name.required' => 'el :attribute es obligatorio',
            'deporte.name.unique' => 'el :attribute ya existe en la base de datos',
            'deporte.name.max' => 'el :attribute debe contener 50 caracteres como máximo',

            'deporte.codigo.required' => 'el :attribute es obligatorio',
            'deporte.codigo.unique' => 'el :attribute ya existe en la base de datos',
            'deporte.codigo.max' => 'el :attribute debe tener 4 caracteres como máximo'
        ];
    }

    public function attributes(): array
    {
        return [
            'deporte.name' => 'nombre del deporte',
            'deporte.codigo' => 'código del deporte'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
