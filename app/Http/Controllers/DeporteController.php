<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteDeporteRequest;
use App\Http\Requests\StoreDeporteRequest;
use App\Http\Requests\UpdateDeporteRequest;
use App\Http\Services\DeporteService;
use App\Models\Deporte;

class DeporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DeporteService::index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeporteRequest $request)
    {
        $deporte = new Deporte();
        $deporte->name = $request['name'];
        return DeporteService::store($deporte);
    }

    /**
     * Display the specified resource.
     */
    public function show(Deporte $deporte)
    {
        return DeporteService::show($deporte);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeporteRequest $request, Deporte $deporte)
    {
        $name = $request['deporte.name'];
        return DeporteService::update($deporte->id, $name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteDeporteRequest $request)
    {
        return DeporteService::delete($request['deporte.id']);
    }
}
