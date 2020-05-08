<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $loginData = $request->only('email', 'password');

        if (! \Auth::attempt($loginData)) {
            return response(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['api_token' => \Auth::user()->api_token]);
    }
}
