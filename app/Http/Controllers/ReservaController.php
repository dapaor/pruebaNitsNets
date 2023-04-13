<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListDiaReservaRequest;
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
     * @OA\Get(
     *     path="/api/reserva",
     *     summary="Mostrar reservas",
     *     tags={"Reserva"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Mostrar todas las reservas."
     *     ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function index()
    {
        return ReservaService::index();
    }

    /**
     * @OA\Post(
     *     path="/api/reserva",
     *     summary="Crear reserva",
     *     security={{"bearerAuth":{}}},
     *     tags={"Reserva"},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Reserva creada de manera exitosa"
     *     ),
     *     @OA\RequestBody(
     *     request="ReservaStoreRequest",
     *     description="Contiene los datos de la reserva a añadir",
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Schema (
     *              @OA\Property (
     *                  type="object",
     *                  @OA\Property (
     *                      property="dia",
     *                      type="date"
     *                  ),
     *                  @OA\Property (
     *                      property="socio_id",
     *                      type="int"
     *                  ),
     *                  @OA\Property (
     *                      property="pista_id",
     *                      type="int"
     *                  ),
     *                  @OA\Property (
     *                      property="hora",
     *                      type="int"
     *                  ),
     *              ),
     *          ),
     *          example={
     *                  "reserva":{
     *                          "dia":"12/04/23",
     *                          "socio_id":12,
     *                          "pista_id":"15",
     *                          "hora":8
     *                  }
     *              }
     *      )
     *      ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function store(StoreReservaRequest $request)
    {
        //
        $reserva = new Reserva();
        $reserva->pista_id = $request['reserva.pista_id'];
        $reserva->socio_id = $request['reserva.socio_id'];
        $reserva->dia = \DateTime::createFromFormat('d/m/y H:i:s', $request['reserva.dia'] . ' 00:00:00')->format('Y-m-d H:i:s');
        $reserva->hora = $request['reserva.hora'];
        return ReservaService::store($reserva);
    }

    /**
     * @OA\Get(
     *     path="/api/reserva/{id}",
     *     summary="Mostrar una reserva",
     *     tags={"Reserva"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Mostrar una reserva."
     *     ),
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="el id de la reserva a mostrar",
     *         required=true
     *     ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function show(Reserva $reserva)
    {
        return ReservaService::show($reserva->id);
    }

    /**
     * @OA\Put(
     *     path="/api/reserva/{id}",
     *     summary="Modificar reserva",
     *     security={{"bearerAuth":{}}},
     *     tags={"Reserva"},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Reserva modificada de manera exitosa"
     *     ),
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="el id de la reserva a modificar",
     *         required=true
     *     ),
     *     @OA\RequestBody(
     *     request="ReservaUpdateRequest",
     *     description="Contiene los datos de la reserva a modificar",
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Schema (
     *              @OA\Property (
     *                  type="object",
     *                  @OA\Property (
     *                      property="dia",
     *                      type="date"
     *                  ),
     *                  @OA\Property (
     *                      property="socio_id",
     *                      type="int"
     *                  ),
     *                  @OA\Property (
     *                      property="pista_id",
     *                      type="string"
     *                  ),
     *                  @OA\Property (
     *                      property="hora",
     *                      type="int"
     *                  ),
     *              ),
     *          ),
     *          example={
     *                  "reserva":{
     *                          "dia":"24/04/23",
     *                          "socio_id":12,
     *                          "pista_id": 15,
     *                          "hora": 10
     *                  }
     *              }
     *      )
     *      ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     *
     * )
     */
    public function update(UpdateReservaRequest $request, Reserva $reserva)
    {
        $data = [
            'dia' => \DateTime::createFromFormat('d/m/y H:i:s', $request['reserva.dia'] . ' 00:00:00')->format('Y-m-d H:i:s'),
            'hora' => $request['reserva.hora'],
            'pista_id' => $request['reserva.pista_id'],
            'socio_id' => $request['reserva.socio_id']
        ];
        return ReservaService::update($data, $reserva->id);
    }

    /**
     * @OA\Delete(
     *     path="/api/reserva/{id}",
     *     summary="Borrar una reserva",
     *     tags={"Reserva"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Reserva eliminada correctamente."
     *     ),
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="el id de la reserva a eliminar",
     *         required=true
     *     ),
     *
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function destroy(Reserva $reserva)
    {
        return ReservaService::delete($reserva->id);
    }

    /**
     * @OA\Post(
     *     path="/api/reserva/dia",
     *     summary="Listado de reservas por día",
     *     security={{"bearerAuth":{}}},
     *     tags={"Reserva"},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Listado de reservas"
     *     ),
     *     @OA\RequestBody(
     *     description="Contiene el día a buscar",
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Schema (
     *              @OA\Property (
     *                  type="object",
     *                  @OA\Property (
     *                      property="dia",
     *                      type="date"
     *                  )
     *              ),
     *          ),
     *          example={
     *                  "dia": "12/04/23"
     *              }
     *      )
     *      ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function listDia(Request $request)
    {
        $dia = \DateTime::createFromFormat('d/m/y H:i:s', $request['dia'] . ' 00:00:00')->format('Y-m-d H:i:s');
        return ReservaService::listDia($dia);
    }
}
