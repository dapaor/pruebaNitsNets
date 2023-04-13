<?php

namespace App\Http\Requests\Pista;

use App\Models\Reserva;
use DateTime;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Factory as ValidationFactory;

class PistasLibresRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend(
            'max3reservas',
            function($parameter_name, $value, $parameters){
                if(count($parameters) < 1){
                    return false;
                }
                $dia = \DateTime::createFromFormat('d/m/y H:i:s', $parameters[0] . '00:00:00')->format('Y-m-d H:i:s');
                return count(DB::query()
                        ->select('dia')
                        ->from('reservas as r')
                        ->where('r.dia', '=', $dia)
                        ->where('r.socio_id', '=', $value)
                        ->get()) < config('databaseConsts.reservas.MAX_RESERVAS_DIA');
            },
            'Un socio no puede tener más de '.config('databaseConsts.reservas.MAX_RESERVAS_DIA').' reservas el mismo día'
        );

        $validationFactory->extend(
            'afterYesterday',
            function ($parameter_name, $value){
                $ayer = new DateTime('today');
                $dia_formateado = DateTime::createFromFormat('d/m/y', $value);
                return $dia_formateado->diff($ayer)->invert > 0;
            },
            'El dia debe ser posterior o igual al día de hoy (dd/mm/yy)'
        );
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'search.dia' => 'required|afterYesterday',
            'search.socio_id' => 'required|exists:socios,id|max3reservas:' . $this['search.dia'],
            'search.deporte_id' => 'required|exists:deportes,id'
        ];
    }
    public function attributes(): array
    {
        return [
            'search.dia' => 'día a buscar',
            'search.socio_id' => 'identificador del socio',
            'search.deporte_id' => 'identificador deporte a buscar',
        ];
    }

    public function messages(): array
    {
        return [
            'search.dia.required' => 'el :attribute es necesario para la búsqueda',

            'search.socio_id.required' => 'el :attribute es obligatorio',
            'search.socio_id.exists' => 'el :attribute debe existir en la base de datos',

            'search.deporte_id.required' => 'el :attribute es obligatorio',
            'search.deporte_id.exists' => 'el :attribute debe existir en la base de datos'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
