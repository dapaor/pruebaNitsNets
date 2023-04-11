<?php

namespace App\Http\Services;

use App\Http\Resources\DeporteResource;
use App\Models\Deporte;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DeporteService
{
    /*
     * @return Deporte[]
     * */
    public static function index() : AnonymousResourceCollection
    {
        return DeporteResource::collection(Deporte::orderBy('name')->paginate(5));
    }
    public static function show($id) : AnonymousResourceCollection
    {
        return DeporteResource::collection(collect([Deporte::find($id)]));
    }
    public static function store(Deporte $deporte) : AnonymousResourceCollection
    {
        $deporte->save();
        return DeporteResource::collection(collect([$deporte]));
    }
    public static function update($id, $name) : AnonymousResourceCollection
    {
        $deporte = Deporte::find($id);
        $deporte->name = $name;
        $deporte->save();
        return DeporteResource::collection(collect([$deporte]));
    }
    public static function delete($id) : AnonymousResourceCollection
    {
        $deporte = Deporte::find($id);
        $deporte->delete();
        return DeporteResource::collection(collect([$deporte]));
    }
}
