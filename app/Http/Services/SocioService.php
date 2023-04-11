<?php

namespace App\Http\Services;

use App\Http\Resources\SocioResource;
use App\Models\Socio;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;

class SocioService
{
    public static function index() : AnonymousResourceCollection
    {
        return SocioResource::collection(Socio::orderBy('apellidos')->paginate(5));
    }
    public static function show($id) : AnonymousResourceCollection
    {
        return SocioResource::collection(collect([Socio::find($id)]));
    }
    public static function store($socio) : AnonymousResourceCollection
    {
        $socio->save();
        return SocioResource::collection(collect([$socio]));
    }
    public static function update(array $data, Socio $socio) : AnonymousResourceCollection
    {
        $socio_update = Socio::find($socio->id);
        foreach($data as $attribute => $value){
            $socio_update->$attribute = $value;
        }
        $socio_update->contrasena = Hash::make($socio_update->contrasena);
        $socio_update->save();
        return SocioResource::collection(collect([$socio_update]));
    }

    public static function delete($id) : AnonymousResourceCollection
    {
        $socio = Socio::find($id);
        $socio->delete();
        return SocioResource::collection(collect([$socio]));
    }
}
