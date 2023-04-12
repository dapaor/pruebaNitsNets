<?php

namespace App\Http\Controllers;

use App\Http\Requests\Deporte\StoreDeporteRequest;
use App\Http\Requests\Deporte\UpdateDeporteRequest;
use App\Http\Services\DeporteService;
use App\Models\Deporte;

class DeporteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/deporte",
     *     summary="Mostrar deportes",
     *     tags={"Deporte"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Mostrar todos los deportes."
     *     ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function index()
    {
        return DeporteService::index();
    }

    /**
     * @OA\Post(
     *     path="/api/deporte",
     *     summary="Crear deporte",
     *     security={{"bearerAuth":{}}},
     *     tags={"Deporte"},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Deporte creado de manera exitosa"
     *     ),
     *     @OA\RequestBody(
     *     request="DeporteStoreRequest",
     *     description="Contiene los datos del deporte a añadir",
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Schema (
     *              @OA\Property (
     *                  type="object",
     *                  @OA\Property (
     *                      property="name",
     *                      type="string"
     *                  ),
     *                  @OA\Property (
     *                      property="codigo",
     *                      type="string"
     *                  ),
     *              ),
     *          ),
     *          example={
     *                  "deporte":{
     *                          "name":"nombreDeporte",
     *                          "codigo":"NDEP",
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
    public function store(StoreDeporteRequest $request)
    {
        $deporte = new Deporte();
        $deporte->name = $request['deporte.name'];
        $deporte->codigo = $request['deporte.codigo'];

        return DeporteService::store($deporte);
    }

    /**
     * @OA\Get(
     *     path="/api/deporte/{id}",
     *     summary="Mostrar un deporte",
     *     tags={"Deporte"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Mostrar un deporte."
     *     ),
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="el id del deporte a mostrar",
     *         required=true
     *     ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function show($deporte)
    {
        return DeporteService::show($deporte);
    }

    /**
     * @OA\Put(
     *     path="/api/deporte/{id}",
     *     summary="Modificar deporte",
     *     security={{"bearerAuth":{}}},
     *     tags={"Deporte"},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Deporte modificado de manera exitosa"
     *     ),
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="el id del deporte a modificar",
     *         required=true
     *     ),
     *     @OA\RequestBody(
     *     request="DeporteUpdateRequest",
     *     description="Contiene los datos del deporte a modificar",
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Schema (
     *              @OA\Property (
     *                  type="object",
     *                  @OA\Property (
     *                      property="name",
     *                      type="string"
     *                  ),
     *                  @OA\Property (
     *                      property="codigo",
     *                      type="string"
     *                  ),
     *              ),
     *          ),
     *          example={
     *                  "deporte":{
     *                          "name":"nombreDeporte",
     *                          "codigo":"NDEP",
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
    public function update(UpdateDeporteRequest $request, Deporte $deporte)
    {
        $name = $request['deporte.name'];
        $codigo = $request['deporte.codigo'];
        return DeporteService::update($deporte->id, $name, $codigo);
    }

    /**
     * @OA\Delete(
     *     path="/api/deporte/{id}",
     *     summary="Borrar un deporte",
     *     tags={"Deporte"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Deporte eliminado correctamente."
     *     ),
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="el id del deporte a eliminar",
     *         required=true
     *     ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function destroy(Deporte $deporte)
    {
        return DeporteService::delete($deporte->id);
    }
}
