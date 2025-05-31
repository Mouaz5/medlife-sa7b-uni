<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class SendResponse
{
    public static function success($data, $message = 'Success', $status = 200)
    {
        return response()->json([
            'status' => 1,
            'data' => $data,
            'message' => $message
        ], $status);
    }

    public static function error($message, $status = 400, $data = [])
    {
        return response()->json([
            'status' => 0,
            'data' => $data,
            'message' => $message
        ], $status);
    }

}
