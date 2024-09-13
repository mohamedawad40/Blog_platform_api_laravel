<?php

namespace App\Http\Controllers;

use App\Http\Requests\authRequest;
use App\Models\User;
use App\utilities\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class authController extends Controller
{
    public function register(authRequest $request)
    {
        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'role'        => $request->role,
            'password'    => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);
        // return ApiResponse::sendResponse(201,'user is created successfully',$token);
        return ApiResponse::respondWithToken($token);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$credentials['email'] || !$credentials['password']) {
            return ApiResponse::sendResponse(400, 'Please provide a valid email and password');
        }

            if (! $token = auth()->attempt($credentials)) {
            return ApiResponse::sendResponse(401,'invalid email or password');
        }

        return ApiResponse::respondWithToken($token);
    }
}
