<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;

class LoginController extends Controller
{
    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $loginData = $request->only('email', 'password');

        if (!\Auth::attempt($loginData)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['api_token' => \Auth::user()->api_token]);
    }
}
