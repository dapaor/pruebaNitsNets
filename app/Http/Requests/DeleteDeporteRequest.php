<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteDeporteRequest extends FormRequest
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
            'deporte.id' => 'required|exists:deportes,id'
        ];
    }
    public function messages()
    {
        return [
            'deporte.id.required' => 'Es necesario especificar un identificador para el deporte',
            'deporte.id.exists' => 'El deporte debe existir en la base de datos'
        ];
    }
}
