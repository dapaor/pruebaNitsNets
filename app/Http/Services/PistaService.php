<?php

namespace App\Http\Services;

use App\Models\Deporte;
use App\Models\Pista;
use App\Http\Resources\PistaResource;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
}
