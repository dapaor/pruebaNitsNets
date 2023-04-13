<?php

namespace App\Http\Services;

use App\Models\Deporte;
use App\Models\Pista;
use App\Http\Resources\PistaResource;
use Carbon\Carbon;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class PistaService
{
    private const NUM_CODIGO_PISTA = 1;

    public static function index() : AnonymousResourceCollection
    {
        return PistaResource::collection(Pista::orderBy('codigo')->paginate(5));
    }
    public static function show($id) : AnonymousResourceCollection
    {
        return PistaResource::collection(collect([Pista::find($id)]));
    }
    public static function store(Pista $pista, $name_deporte)
    {
        $deporte = Deporte::with('pistas')->where('name',$name_deporte)->get()->first();
        $pista->codigo = self::getCodigoPista($deporte->codigo, $deporte->pistas->toArray());
        $pista->deporte_id = $deporte->id;
        $pista->save();
        return PistaResource::collection(collect([$pista]));
    }
    private static function getCodigoPista (string $cod_deporte, array $pistas) : string
    {
        $array_num_codigos_pistas = array();
        foreach($pistas as $pista){
            $array_num_codigos_pistas[] = explode('-', $pista['codigo'])[self::NUM_CODIGO_PISTA];
        }
        return $cod_deporte . '-' . (empty($array_num_codigos_pistas) ? 1 : max($array_num_codigos_pistas)+1);
    }
    public static function update($data, $id)
    {
        $pista = Pista::find($id);
        $deporte = Deporte::with('pistas')->where('name',$data['deporte'])->get()->first();
        $pista->codigo = self::getCodigoPista($deporte->codigo, $deporte->pistas->toArray());
        $pista->deporte_id = $deporte->id;
        $pista->ancho = $data['ancho'];
        $pista->largo = $data['largo'];
        $pista->save();
        return PistaResource::collection(collect([$pista]));
    }
    public static function delete($code)
    {
        $pista = Pista::where('codigo', $code)->get()->first();
        $pista->delete();
        return PistaResource::collection(collect([$pista]));
    }

    private static function getPistasByDeporte($deporte_id)
    {
        return Pista::where('deporte_id',$deporte_id)->get();
    }

    private static function getReservasByDiaAndDeporte($dia, $deporte_id)
    {
        $dia_formatted = \DateTime::createFromFormat('d/m/y H:i:s', $dia . ' 00:00:00')->format('Y-m-d H:i:s');
        return DB::query()
            ->select(['r.pista_id', 'r.hora'])
            ->from('reservas as r')
            ->join('pistas as p', function ($join) use($dia_formatted){
                $join->on('p.id', '=', 'r.pista_id');
                $join->where('r.dia', '=', $dia_formatted);
            })
            ->where('p.deporte_id','=', $deporte_id)
            ->get();
    }
    private static function prepareDisponibles($pistas, $reservas_deporte)
    {
        $horasDisponiblesPorPista = array();

        foreach ($pistas as $pista) {
            $horasDisponibles = range(config('databaseConsts.reservas.MIN_HORA_RESERVA'),
                config('databaseConsts.reservas.MAX_HORA_RESERVA'));
            foreach ($reservas_deporte as $reserva) {
                if ($reserva->pista_id == $pista['id']) {
                    if (($key = array_search($reserva->hora, $horasDisponibles)) !== false) {
                        unset($horasDisponibles[$key]);
                    }
                }
            }
            $horasDisponiblesPorPista[$pista['codigo']] = array_values($horasDisponibles);
        }

        return $horasDisponiblesPorPista;
    }
    public static function search(array $data)
    {
        $reservas_deporte = self::getReservasByDiaAndDeporte($data['dia'], $data['deporte_id']);
        $pistas = self::getPistasByDeporte($data['deporte_id']);
        $disponibles = self::prepareDisponibles($pistas, $reservas_deporte);
        return response()->json(["data" =>$disponibles], 200);
    }
}
