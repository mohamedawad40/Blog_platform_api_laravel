<?php

namespace App\utilities;
use Illuminate\Support\Facades\Response;


class ApiError{
    static function sendError(string $error, int $statusCode)
    {
        return response()->json([
            'status' => 'fail',
            'message' => $error,
        ], $statusCode);
    }
}
