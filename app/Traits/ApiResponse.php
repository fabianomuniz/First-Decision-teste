<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

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
        if ($data instanceof LengthAwarePaginator) {
            $pagination = $data->toArray();
            $items = $pagination['data'];

            $meta = [
                'current_page' => $pagination['current_page'],
                'last_page' => $pagination['last_page'],
                'per_page' => $pagination['per_page'],
                'total' => $pagination['total'],
            ];

            return response()->json([
                'data' => $items,
                'meta' => $meta,
            ], $statusCode);
        }

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
