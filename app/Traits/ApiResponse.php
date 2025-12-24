<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Success Response
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function success($data = null, string $message = 'Success', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'errors' => null,
        ], $statusCode);
    }

    /**
     * Error Response
     *
     * @param mixed $errors
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function error($errors = null, string $message = 'Error', int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'data' => null,
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }
}
