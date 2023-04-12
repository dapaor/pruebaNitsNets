<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reserva\StoreReservaRequest;
use App\Http\Requests\Reserva\UpdateReservaRequest;
use App\Http\Resources\ReservaResource;
use App\Http\Services\ReservaService;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ReservaService::index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservaRequest $request)
    {
        //
        $reserva = new Reserva();
        $reserva->pista_id = $request['reserva.pista_id'];
        $reserva->socio_id = $request['reserva.socio_id'];
        $reserva->dia = $request['reserva.dia'];
        $reserva->hora = $request['reserva.hora'];
        return ReservaService::store($reserva);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        return ReservaService::show($reserva->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservaRequest $request, Reserva $reserva)
    {
        $data = [
            'dia' => Carbon::createFromFormat('d/m/y h:i:s', $request['reserva.dia'] . ' 00:00:00'),
            'hora' => $request['reserva.hora'],
            'pista_id' => $request['reserva.pista_id'],
            'socio_id' => $request['reserva.socio_id']
        ];
        return ReservaService::update($data, $reserva->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        return ReservaService::delete($reserva->id);
    }
}
