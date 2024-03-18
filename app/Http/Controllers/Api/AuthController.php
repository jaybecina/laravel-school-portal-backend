<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Enums\TokenAbility;
use Carbon\Carbon;
use App\Models\User;


class AuthController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'email|required',
            'password' => 'required|string',
        ]);

        if(!Auth::attempt($login)){ 
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized'], 401);
        }

        $user = Auth::user(); 
        $accessToken = $user->createToken('accessToken')->plainTextToken; 

        // $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.expiration')));
        // $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], Carbon::now()->addMinutes(config('sanctum.rt_expiration'))); // 365 * 24 * 60,  1 year
        
        return $this->sendResponse([
            "user" => $user, 
            "accessToken" => $accessToken,
        ], 'User login successfully.');
        //->withCookie($cookie);
    }

    /**
     * Logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        // $cookie = \Cookie::forget('accessToken');

        return $this->sendResponse(null, 'User logout successfully.');
        //->withoutCookie($cookie)
    }

    /**
     * Refresh token api
     *
     * @return \Illuminate\Http\Response
     */
    public function refreshToken(Request $request)
    {
        if($request->personal_access_token === config('refreshtoken.personal_access_token')) {
            $user = User::find($request->userId);
            $accessToken = $user->createToken('accessToken')->plainTextToken; 
            // $accessToken = $request->user()->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.expiration')));
            return response(['message' => "Token refreshed", 'accessToken' => $accessToken]);
        } else {
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized'], 401);
        }
    }
}
