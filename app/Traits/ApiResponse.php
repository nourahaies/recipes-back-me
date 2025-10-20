<?php

namespace App\Traits;

trait ApiResponse
{
    protected function successResponse($data = null, $message = 'Success', $status = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    protected function errorResponse($message = 'Something went wrong', $status = 500)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $status);
    }
}
