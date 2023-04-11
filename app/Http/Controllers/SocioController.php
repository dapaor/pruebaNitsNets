<?php

namespace App\Http\Controllers;

use App\Http\Requests\Socio\StoreSocioRequest;
use App\Http\Requests\Socio\UpdateSocioRequest;
use App\Http\Services\SocioService;
use App\Models\Socio;
use Illuminate\Support\Facades\Hash;

class SocioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SocioService::index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSocioRequest $request)
    {
        $socio = new Socio();
        $socio->apellidos = $request['socio.apellidos'];
        $socio->nombre = $request['socio.nombre'];
        $socio->dni = $request['socio.dni'];
        $socio->email = $request['socio.email'];
        $socio->contrasena = Hash::make($request['socio.contrasena']);
        return SocioService::store($socio);
    }

    /**
     * Display the specified resource.
     */
    public function show(Socio $socio)
    {
        return SocioService::show($socio->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocioRequest $request, Socio $socio)
    {
        //
        $data = array();
        foreach($request['socio'] as $key => $value){
            $data[$key] = $value;
        }
        return SocioService::update($data, $socio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Socio $socio)
    {
        return SocioService::delete($socio->id);
    }
}
