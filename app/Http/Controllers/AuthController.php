<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthController\LoginRequest;
use App\Http\Requests\AuthController\SignupRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $user = User::create($request->validated());
        $user->update(['password' => Hash::make($request->password)]);
        $token = $user->createToken($user->email, ['doctor'])->plainTextToken;
        return response()->json([
            'message' => 'success',
            'token' => $token,
            'user' => new UserResource($user),
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = User::query()->where('email', request()->email)->firstOrFail();
        abort_if(!Hash::check(request()->password, $user->password), 400, 'wrong email or password');
        $token = $user->createToken($user->email, ['doctor'])->plainTextToken;
        return response()->json([
            'message' => 'success',
            'token' => $token,
            'user' => new UserResource($user),
        ]);
    }
}
