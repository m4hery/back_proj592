<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $token = JWT::encode($user,env('JWT_SECRET'), 'HS256');

            return response()->json([
                'token' => $token
            ]);
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }


}
