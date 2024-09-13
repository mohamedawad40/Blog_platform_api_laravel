<?php

namespace App\utilities;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;


class ApiResponse {
    static function sendResponse($code = 200, $msg = null, $data = null){

        $response = [
            'status' => $code,
            'msg'    => $msg,
            'data'   => $data
        ];

        return Response::json($response,$code);
    }

    static function respondWithToken($token)
    {
        return response()->json([
            'status'         => 201,
            'access_token'   => $token,
            'token_type'     => 'bearer',
        ]);
    }
}
