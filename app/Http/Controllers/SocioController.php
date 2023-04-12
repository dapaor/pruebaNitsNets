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
     * @OA\Get(
     *     path="/api/socio",
     *     summary="Mostrar socios",
     *     tags={"Socio"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Mostrar todos los socios."
     *     ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function index()
    {
        return SocioService::index();
    }

    /**
     * @OA\Post(
     *     path="/api/socio",
     *     summary="Crear socio",
     *     security={{"bearerAuth":{}}},
     *     tags={"Socio"},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Socio creado de manera exitosa"
     *     ),
     *     @OA\RequestBody(
     *     request="SocioStoreRequest",
     *     description="Contiene los datos del socio a añadir",
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Schema (
     *              @OA\Property (
     *                  type="object",
     *                  @OA\Property (
     *                      property="nombre",
     *                      type="string"
     *                  ),
     *                  @OA\Property (
     *                      property="apellidos",
     *                      type="string"
     *                  ),
     *                  @OA\Property (
     *                      property="dni",
     *                      type="string"
     *                  ),
     *                  @OA\Property (
     *                      property="email",
     *                      type="string"
     *                  ),
     *                  @OA\Property (
     *                      property="contrasena",
     *                      type="string"
     *                  ),
     *              ),
     *          ),
     *          example={
     *                  "socio":{
     *                          "nombre":"Prueba",
     *                          "apellidos":"Socios",
     *                          "dni":"12343212E",
     *                          "email":"example@example.com",
     *                          "contrasena":"12341234",
     *                  }
     *              }
     *      )
     *      ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
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
     * @OA\Get(
     *     path="/api/socio/{id}",
     *     summary="Mostrar un socio",
     *     tags={"Socio"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Mostrar un socio."
     *     ),
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="el id del socio a mostrar",
     *         required=true
     *     ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function show(Socio $socio)
    {
        return SocioService::show($socio->id);
    }

    /**
     * @OA\Put(
     *     path="/api/socio/{id}",
     *     summary="Modificar socio",
     *     security={{"bearerAuth":{}}},
     *     tags={"Socio"},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Socio modificado de manera exitosa"
     *     ),
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="el id del socio a modificar",
     *         required=true
     *     ),
     *     @OA\RequestBody(
     *     request="SocioUpdateRequest",
     *     description="Contiene los datos del socio a modificar",
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Schema (
     *              @OA\Property (
     *                  type="object",
     *                  @OA\Property (
     *                      property="nombre",
     *                      type="string"
     *                  ),
     *                  @OA\Property (
     *                      property="contrasena",
     *                      type="string"
     *                  ),
     *              ),
     *          ),
     *          example={
     *                  "socio":{
     *                          "nombre":"PruebaPut",
     *                          "contrasena":"12341234",
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
     * @OA\Delete(
     *     path="/api/socio/{id}",
     *     summary="Borrar un socio",
     *     tags={"Socio"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Socio eliminado correctamente."
     *     ),
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="el id del socio a eliminar",
     *         required=true
     *     ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function destroy(Socio $socio)
    {
        return SocioService::delete($socio->id);
    }
}
