<?php

namespace App\Http\Controllers\UserControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthUserResource;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = request(['email', 'password']);

        $credentials['isActive'] = true;

        if (!$token = auth()->guard('api')->attempt($credentials)) {

            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::where('email', request()->email)->first();

        $user->update([
            'last_login' => now(),
//            'lat' => $request->lat,
//            'long' => $request->long,
        ]);

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return AuthUserResource
     */
    public function getAuthUser(): AuthUserResource
    {
        return new AuthUserResource(auth()->guard('api')->user());

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {

        auth()->guard('api')->logout();

        return response()->json(['message' => 'logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->guard('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60,
            'statusCode' => 200
        ]);
    }

}
