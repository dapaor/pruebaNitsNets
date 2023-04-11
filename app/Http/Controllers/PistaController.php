<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pista\DeletePistaRequest;
use App\Http\Requests\Pista\StorePistaRequest;
use App\Http\Requests\Pista\UpdatePistaRequest;
use App\Http\Services\PistaService;
use App\Models\Pista;

class PistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PistaService::index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePistaRequest $request)
    {
       $pista = new Pista();
       $pista->ancho = $request['pista.ancho'];
       $pista->largo = $request['pista.largo'];
       $name_deporte = $request['pista.deporte'];
       return PistaService::store($pista,$name_deporte);
    }

    /**
     * Display the specified resource.
     */
    public function show($pista)
    {
        return PistaService::show($pista);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePistaRequest $request, $pista)
    {
        $data = ['largo' => $request['pista.largo'],
                'ancho' => $request['pista.ancho'],
                'deporte' => $request['pista.deporte']];
        return PistaService::update($data, $pista);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeletePistaRequest $request)
    {
        return PistaService::delete($request['pista.code']);
    }
}
