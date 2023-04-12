<?php

namespace App\Http\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public static function index()
    {
        return UserResource::collection(User::all());
    }
    public static function show($id)
    {
        $user = User::find($id);
        return UserResource::collection(collect([$user]));
    }
    public static function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return UserResource::collection(collect([$user]));
    }

    public static function store(User $user)
    {
        $user->password = Hash::make($user->password);
        $user->save();
        return UserResource::collection(collect([$user]));
    }

    public static function login($email)
    {
        $user = User::where('email', $email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return ['user' => UserResource::collection(collect([$user])), 'token' => $token];
    }

    public static function update($data, $user_id)
    {
        $user = User::find($user_id);
        foreach($data as $attribute => $value){
            $user->$attribute = $value;
        }
        $user->password = Hash::make($user->password);
        $user->save();
        return UserResource::collection(collect([$user]));
    }
}
