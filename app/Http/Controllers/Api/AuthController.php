<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth as JWTAuthService;

class AuthController extends Controller
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuthService $jwt)
    {
        $this->jwt = $jwt;
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        try {
            if (!$token = $this->jwt->attempt($credentials)) {
                return response()->json(['message' => 'Credenciais inválidas'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token'], 500);
        }
        Log::info('JWT token generated', ['token' => $token]);

        return response()->json(['token' => $token, 'token_type' => 'Bearer'], 200);
    }

    public function logout(Request $request)
    {
        $token = $this->jwt->getToken();
        if ($token) {
            // Call the Manager invalidate which accepts a Token instance
            $this->jwt->manager()->invalidate($token);
        }

        return response()->json(['message' => 'Logout realizado']);
    }
}
