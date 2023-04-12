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
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserService::index();
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return UserService::delete($user->id);
    }

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
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successful logout!'
        ],200);
    }
}
