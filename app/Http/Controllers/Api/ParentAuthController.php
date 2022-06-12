<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Traits\GeneralTrait;
use App\Http\Requests\Backend\AuthRequest;

class ParentAuthController extends Controller
{
    use GeneralTrait;

    public function __construct()
    {
        $this->middleware('auth.guard:parent_api', ['except' => ['login', 'register']]);
    }

    public function login(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->returnError(200, 'Login credentials are invalid.');
            }
        } catch (JWTException $e) {
            return $this->returnError(201, 'Could not create token.');
        }
        return $this->returnData('token', $token, 'success');
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate($request->token);
            return $this->returnSuccessMessage('User has been logged out');
        } catch (JWTException $exception) {
            return $this->returnError(200, 'Sorry, user cannot be logged out');
        }
    }

    public function refresh()
    {
        return $this->createNewToken(Auth::refresh());
    }

    public function userProfile()
    {
        return response()->json(Auth::user());
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->setTTL(60 * 24),
            'token' => $token,
        ]);
    }

}