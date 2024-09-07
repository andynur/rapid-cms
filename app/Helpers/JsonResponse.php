<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse as LaravelJsonResponse;
use Illuminate\Http\Response;

class JsonResponse
{
    /**
     * Format response method.
     *
     * @param mixed  $data
     * @param string $message
     * @param int    $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function format($data = null, $message = 'Request succeeded', $status = 200, $meta = null): LaravelJsonResponse
    {
        $response = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];

        // Add meta information if provided
        if ($meta) {
            $response['meta'] = $meta;
        }

        return response()->json($response, $status);
    }

    public static function success($data = null, $message = 'Request succeeded', $meta = null): LaravelJsonResponse
    {
        return self::format($data, $message, Response::HTTP_OK, $meta);
    }

    public static function created($data = null, $message = 'Data created'): LaravelJsonResponse
    {
        return self::format($data, $message, Response::HTTP_CREATED);
    }

    /**
     * Error response method.
     *
     * @param string $message
     * @param array|string $errors
     * @param int    $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message = 'An error occurred', $errors = [], $status = 400): LaravelJsonResponse
    {
        return response()->json([
            'status'  => $status,
            'message' => $message,
            'errors'  => $errors,
        ], $status);
    }

    public static function unauthorized($message = 'Unauthentiated'): LaravelJsonResponse
    {
        return self::error($message, [], Response::HTTP_UNAUTHORIZED);
    }

    public static function notFound($message = 'Not Found'): LaravelJsonResponse
    {
        return self::error($message, [], Response::HTTP_NOT_FOUND);
    }
}
