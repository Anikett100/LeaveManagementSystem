<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
        public function login()
        {
            $credentials = request(['email', 'password']);
            // dd( $credentials);
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return $this->respondWithToken($token);
        }


    public function me()
    {
        return response()->json(auth()->user());
    }
  
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

  
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
   
    protected function respondWithToken($token)
    {
        $user = auth()->user();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
             'expires_in' => auth()->factory()->getTTL() * 60,
             'user'=>auth()->user(),
             'user_id' => $user->id,
             'role' => $user->role,   
            
        ]);
    }


    
}