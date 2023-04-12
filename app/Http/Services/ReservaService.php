<?php

namespace App\Http\Services;

use App\Http\Resources\ReservaResource;
use App\Models\Reserva;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReservaService
{
    public static function index() : AnonymousResourceCollection
    {
        return ReservaResource::collection(Reserva::orderBy('dia', 'desc')->paginate(5));
    }
    public static function show($id) : AnonymousResourceCollection
    {
        return ReservaResource::collection(collect([Reserva::find($id)]));
    }
    public static function store(Reserva $reserva) : AnonymousResourceCollection
    {
        $reserva->save();
        return ReservaResource::collection(collect([$reserva]));
    }
    public static function update(array $data, $reserva_id) : AnonymousResourceCollection
    {
        $reserva = Reserva::find($reserva_id);
        foreach($data as $attribute => $value){
            $reserva->$attribute = $value;
        }
        $reserva->save();
        return ReservaResource::collection(collect([$reserva]));
    }
    public static function delete($id) : AnonymousResourceCollection
    {
        $reserva = Reserva::find($id);
        $reserva->delete();
        return ReservaResource::collection(collect([$reserva]));
    }
}
