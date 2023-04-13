<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pista\DeletePistaRequest;
use App\Http\Requests\Pista\PistasLibresRequest;
use App\Http\Requests\Pista\StorePistaRequest;
use App\Http\Requests\Pista\UpdatePistaRequest;
use App\Http\Services\PistaService;
use App\Models\Pista;

class PistaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pista",
     *     summary="Mostrar pistas",
     *     tags={"Pista"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Mostrar todas las pistas."
     *     ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function index()
    {
        return PistaService::index();
    }

    /**
     * @OA\Post(
     *     path="/api/pista",
     *     summary="Crear pista",
     *     security={{"bearerAuth":{}}},
     *     tags={"Pista"},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Pista creada de manera exitosa"
     *     ),
     *     @OA\RequestBody(
     *     request="PistaStoreRequest",
     *     description="Contiene los datos de la pista a añadir",
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Schema (
     *              @OA\Property (
     *                  type="object",
     *                  @OA\Property (
     *                      property="ancho",
     *                      type="int"
     *                  ),
     *                  @OA\Property (
     *                      property="largo",
     *                      type="int"
     *                  ),
     *                  @OA\Property (
     *                      property="deporte",
     *                      type="string"
     *                  ),
     *              ),
     *          ),
     *          example={
     *                  "pista":{
     *                          "ancho":60,
     *                          "largo":120,
     *                          "deporte":"balonmano"
     *                  }
     *              }
     *      )
     *      ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
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
     * @OA\Get(
     *     path="/api/pista/{id}",
     *     summary="Mostrar una pista",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Mostrar una pista."
     *     ),
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="el id de la pista a mostrar",
     *         required=true
     *     ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function show($pista)
    {
        return PistaService::show($pista);
    }

    /**
     * @OA\Put(
     *     path="/api/pista/{id}",
     *     summary="Modificar pista",
     *     security={{"bearerAuth":{}}},
     *     tags={"Pista"},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Pista modificada de manera exitosa"
     *     ),
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="el id de la pista a modificar",
     *         required=true
     *     ),
     *     @OA\RequestBody(
     *     request="PistaUpdateRequest",
     *     description="Contiene los datos de la pista a modificar",
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Schema (
     *              @OA\Property (
     *                  type="object",
     *                  @OA\Property (
     *                      property="ancho",
     *                      type="int"
     *                  ),
     *                  @OA\Property (
     *                      property="largo",
     *                      type="int"
     *                  ),
     *                  @OA\Property (
     *                      property="deporte",
     *                      type="string"
     *                  ),
     *              ),
     *          ),
     *          example={
     *                  "pista":{
     *                          "ancho":40,
     *                          "largo":100,
     *                          "deporte": "baloncesto"
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
    public function update(UpdatePistaRequest $request, $pista)
    {
        $data = ['largo' => $request['pista.largo'],
                'ancho' => $request['pista.ancho'],
                'deporte' => $request['pista.deporte']];
        return PistaService::update($data, $pista);
    }

    /**
     * @OA\Delete(
     *     path="/api/pista/{id}",
     *     summary="Borrar una pista",
     *     tags={"Pista"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Pista eliminada correctamente."
     *     ),
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="el id de la pista a eliminar",
     *         required=true
     *     ),
     *     @OA\RequestBody(
     *     request="PistaDeleteRequest",
     *     description="Contiene el código de la pista a elimianr",
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Schema (
     *              @OA\Property (
     *                  type="object",
     *                  @OA\Property (
     *                      property="codigo",
     *                      type="int"
     *                  ),
     *              ),
     *          ),
     *          example={
     *                  "pista":{
     *                          "code":"BASK-11"
     *                  }
     *              }
     *      )
     *      ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function destroy(DeletePistaRequest $request)
    {
        return PistaService::delete($request['pista.code']);
    }

    /**
     * @OA\Post(
     *     path="/api/pista/search",
     *     summary="Buscar pistas disponibles",
     *     security={{"bearerAuth":{}}},
     *     tags={"Pista"},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Listado de pistas disponibles"
     *     ),
     *     @OA\RequestBody(
     *     request="PistasLibresRequest",
     *     description="Contiene los datos de las pistas a buscar",
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
     *                      property="deporte_id",
     *                      type="int"
     *                  ),
     *                  @OA\Property (
     *                      property="socio_id",
     *                      type="int"
     *                  ),
     *              ),
     *          ),
     *          example={
     *                  "search":{
     *                          "dia":"16/04/23",
     *                          "deporte_id":2,
     *                          "socio_id":8
     *                  }
     *              }
     *      )
     *      ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function search(PistasLibresRequest $request)
    {
        $data = ['dia' => $request['search.dia'], 'deporte_id' => $request['search.deporte_id']];
        return PistaService::search($data);
    }
}
