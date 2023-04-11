<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdatePistaRequest extends FormRequest
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
            'pista.ancho' =>
                'required|numeric|max:' . (config('databaseConsts.pistas.MAX_ANCHO')) .
                '|min:' . (config('databaseConsts.pistas.MIN_ANCHO'))
            ,
            'pista.largo' =>
                'required|numeric|max:' . (config('databaseConsts.pistas.MAX_LARGO')) .
                '|min:' . (config('databaseConsts.pistas.MIN_LARGO'))
            ,
            'pista.deporte' => [
                'required',
                Rule::exists('deportes', 'name')
            ]
        ];
    }
    public function attributes():array
    {
        return [
            'pista.ancho' => 'ancho',
            'pista.largo' => 'largo',
            'pista.deporte' => 'deporte'
        ];
    }

    public function messages():array
    {
        return [
            'pista.ancho.required' => 'El :attribute es necesario para añadir una pista',
            'pista.ancho.min' => 'El :attribute tiene que ser mayor que ' . config('databaseConsts.pistas.MIN_ANCHO'),
            'pista.ancho.max' => 'El :attribute tiene que ser menor que ' . config('databaseConsts.pistas.MAX_ANCHO'),

            'pista.largo.required' => 'El :attribute es necesario para añadir una pista',
            'pista.largo.min' => 'El :attribute tiene que ser mayor que ' . config('databaseConsts.pistas.MIN_LARGO'),
            'pista.largo.max' => 'El :attribute tiene que ser menor que ' . config('databaseConsts.pistas.MAX_LARGO'),

            'pista.deporte.required' => 'La pista debe tener asignada un :attribute',
            'pista.deporte.exists' => 'El deporte debe existir en la base de datos'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
