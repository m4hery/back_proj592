<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            return response()->json([
                'user' => $user
            ]);
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }


}
