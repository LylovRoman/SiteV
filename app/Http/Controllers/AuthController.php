<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::query()->create($request->all());
        return response()->json([
            "data" => [
                "token" => $user->generateToken()
            ]
        ], 200);
    }

    public function auth(AuthRequest $request)
    {
        $user = User::query()->where('phone', $request->phone)->first();
        if($user->password == $request->password) {
            return response()->json([
                "data" => [
                    "token" => $user->generateToken()
                ]
            ], 200);
        }
        return response()->json([
            "error" => [
                'code' => 401,
                'message' => 'Unauthorized',
                'phone' => ['phone or password incorrect']
            ]
        ]);
    }
}
