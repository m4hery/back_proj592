<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $vs = Validator::make($request->all(), [
            /**
             * @example design@pattern.exam
             */
            'email' => 'required',
            /**
             * @example milay_ny_design_pattern
             */
            'password' => 'required'
        ]);

        if ($vs->fails()) {
            return response()->json([
                'message' => $vs->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = User::where('email', $request->email)->first()->toArray();
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
