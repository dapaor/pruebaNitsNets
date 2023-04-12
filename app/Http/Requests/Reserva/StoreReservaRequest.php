<?php

namespace App\Http\Requests\Reserva;

use App\Models\Reserva;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Factory as ValidationFactory;

class StoreReservaRequest extends FormRequest
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
                return count(Reserva::where('socio_id', $value)
                                    ->where('dia', $parameters[0])
                                    ->get()) < config('databaseConsts.reservas.MAX_RESERVAS_DIA');
            },
            'Un socio no puede tener más de '.config('databaseConsts.reservas.MAX_RESERVAS_DIA').' reservas el mismo día'
        );

        $validationFactory->extend(
            'reservaMismaHora',
            function($parameter_name, $value, $parameters){
                foreach($parameters as $param){
                    if(empty($param)){
                        return false;
                    }
                }
                return count(Reserva::where('pista_id', $value)
                                    ->where('dia', $parameters[0])
                                    ->where('hora', $parameters[1])
                                    ->get()) < 1;
            },
            'La pista no está disponible el día escogido a la hora escogida'
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
            'reserva.dia' => 'required|after:'.Carbon::yesterday()->format('d/m/y'),
            'reserva.hora' => 'required|numeric|max:' . config('databaseConsts.reservas.MAX_HORA_RESERVA'). '|min:' . config('databaseConsts.reservas.MIN_HORA_RESERVA'),
            'reserva.socio_id' => 'required|exists:socios,id|max3reservas:' . $this['reserva.dia'],
            'reserva.pista_id' => 'required|reservaMismaHora:'. $this['reserva.dia'].','.$this['reserva.hora']
        ];
    }

    public function attributes(): array
    {
        return [
            'reserva.pista_id' => 'identificador de la pista',
            'reserva.socio_id' => 'identificador del socio',
            'reserva.dia' => 'día de la reserva',
            'reserva.hora' => 'hora de la reserva'
        ];
    }

    public function messages(): array
    {
        return [
            'reserva.pista_id.required' => 'el :attribute es obligatorio',

            'reserva.socio_id.required' => 'el :attribute es obligatorio',
            'reserva.socio_id.exists' => 'el :attribute debe existir en la base de datos',

            'reserva.dia.required' => 'el :attribute es necesario para realizar la reserva',
            'reserva.dia.after'=>'El :attribute debe ser posterior o igual al día de hoy (dd/mm/yy)',

            'reserva.hora.max' => 'La :attribute no puede exceder de las ' . config('databaseConsts.reservas.MAX_HORA_RESERVA'),
            'reserva.hora.min' => 'La :attribute no puede ser anterior a las ' .config('databaseConsts.reservas.MIN_HORA_RESERVA'),
            'reserva.hora.required' => 'La :attribute es necesaria para realizar la reserva'
            ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
