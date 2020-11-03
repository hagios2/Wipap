<?php

namespace App\Http\Controllers\WMCControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\WmcAdminResource;
use App\WasteCompanyAdmin;
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
        $this->middleware('auth:wmc_admin', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $credentials['isActive'] = true;

        if (! $token = auth()->guard('wmc_admin')->attempt($credentials)) {

            $admin = WasteCompanyAdmin::where('email', request()->email)->first();

            $admin->update(['last_login' => now()]);

            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUser()
    {

        return new WmcAdminResource(auth()->guard('wmc_admin')->user());

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {

        auth()->guard('wmc_admin')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->guard('wmc_admin')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('wmc_admin')->factory()->getTTL() * 60,
            'statusCode' => 200
        ]);
    }


    public function saveValidId(Request $request)
    {
        $request->validate(['valid_id' => 'nullable|image|mimes:png,jpg,jpeg']);

        $file = $request->file('valid_id');

        $user = auth()->guard('api')->user();

        $fileName = $file->getClientOriginalName();

        $path = "public/valid ids/$user->id/";

        $file->storeAs($path, $fileName);

        $user->update(['valid_id' => $path.$fileName]);

        return response()->json(['status' => 'File saved']);
    }


}
