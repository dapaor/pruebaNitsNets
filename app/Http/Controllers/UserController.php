<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/user",
 *     summary="Mostrar usuarios",
 *     tags={"User"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         @OA\JsonContent(),
 *         response=200,
 *         description="Mostrar todos los usuarios."
 *     ),
 *     @OA\MediaType(
 *     mediaType="application/json"
 *     ),
 * )
 */
    public function index()
    {
        return UserService::index();
    }
    /**
     * @OA\Post(
     *     path="/api/user",
     *     summary="Crear usuario",
     *     security={{"bearerAuth":{}}},
     *     tags={"User"},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Usuario creado de manera exitosa"
     *     ),
     *     @OA\RequestBody(
     *     request="UserStoreRequest",
     *     description="Contiene los datos del usuario a añadir",
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Schema (
     *              @OA\Property (
     *                  type="object",
     *                  @OA\Property (
     *                      property="email",
     *                      type="string"
     *                  ),
     *                  @OA\Property (
     *                      property="password",
     *                      type="string"
     *                  ),
     *                  @OA\Property (
     *                      property="name",
     *                      type="string"
     *                  ),
     *              ),
     *          ),
     *          example={
     *                  "user":{
     *                          "email":"test@gmail.com",
     *                          "password":"12341234",
     *                          "name":"prueba"
     *                  }
     *              }
     *      )
     *      ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error.",
     *         @OA\JsonContent(),
     *     )
     * )
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request['user.name'],
            'email' => $request['user.email'],
            'password' => $request['user.password']
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'data' => UserService::store($user),
            'access_token' => $token,
            'token_type' => 'Bearer'
            ],200
        );
    }

    /**
     * @OA\Get(
     *     path="/api/user/{id}",
     *     summary="Mostrar un usuario",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Mostrar un usuarios."
     *     ),
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="el id del usuario a mostrar",
     *         required=true
     *     ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function show(User $user)
    {
        return UserService::show($user->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * @OA\Delete(
     *     path="/api/user/{id}",
     *     summary="Borrar un usuario",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Mostrar todos los usuarios."
     *     ),
     *     @OA\Parameter (
     *         name="id",
     *         in="path",
     *         description="el id del usuario a eliminar",
     *         required=true
     *     ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function destroy(User $user)
    {
        return UserService::delete($user->id);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login",
     *     tags={"Autenticacion"},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Login exitoso"
     *     ),
     *     @OA\RequestBody(
     *     request="LoginRequest",
     *     description="Contiene el email y la contraseña a loggear",
     *     required=true,
     *     @OA\JsonContent(
     *          @OA\Schema (
     *              @OA\Property (
     *                  type="object",
     *                  @OA\Property (
     *                      property="email",
     *                      type="string"
     *                  ),
     *                  @OA\Property (
     *                      property="password",
     *                      type="string"
     *                  ),
     *              ),
     *          ),
     *          example={
     *                 "user":{
     *                          "email":"test@gmail.com",
     *                          "password":"12341234",
     *                  }
     *           }
     *      )
     *      ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error.",
     *         @OA\JsonContent(),
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        $credentials = ['email' => $request['user.email'], 'password' => $request['user.password']];
        if(!Auth::attempt($credentials)){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $data = UserService::login($request['user.email']);
        return response()->json(
            [
                'message' => 'Successful log in' ,
                'accessToken' => $data['token'],
                'token_type' => 'Bearer',
                'user' => $data['user']
            ], 200
        );
    }
    /**
     * @OA\Get(
     *     path="/api/logout",
     *     summary="Cerrar sesión",
     *     tags={"Autenticacion"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         @OA\JsonContent(),
     *         response=200,
     *         description="Cerrar sesión"
     *     ),
     *     @OA\MediaType(
     *     mediaType="application/json"
     *     ),
     * )
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successful logout!'
        ],200);
    }
}
