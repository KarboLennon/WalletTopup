<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('phone_number', 'pin');

        $user = User::where('phone_number', $credentials['phone_number'])
                    ->where('pin', $credentials['pin'])
                    ->first();

        if (!$user) {
            return response()->json([
                'message' => 'Phone number and pin doesn’t match.'
            ], 401);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => 'SUCCESS',
            'result' => [
                'access_token' => $token,
                'refresh_token' => $token // pakai token sama untuk refresh (mockup)
            ]
        ]);
    }
}
