<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateDeporteRequest extends FormRequest
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
            'deporte.name' => [
                'required',
                Rule::unique('deportes', 'name')
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'deporte.name.required' => 'el :attribute es obligatorio',
            'deporte.name.unique' => 'el :attribute ya existe en la base de datos'
        ];
    }

    public function attributes(): array
    {
        return [
            'deporte.name' => 'nombre del deporte',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
