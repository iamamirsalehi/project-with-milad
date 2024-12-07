<?php

namespace App\Src\UI\Response;

use Illuminate\Http\Response as IlluminateJsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponse
{

    public static function ok(string $message = '', array $data = []): IlluminateJsonResponse
    {
        return self::json(Response::HTTP_OK, $message, $data);
    }

    public static function created(string $message = '', array $data = []): IlluminateJsonResponse
    {
        return self::json(Response::HTTP_CREATED, $message, $data);
    }

    public static function forbidden(string $message = '', array $data = []): IlluminateJsonResponse
    {
        return self::json(Response::HTTP_FORBIDDEN, $message, $data);
    }

    public static function internalServerError(string $message): IlluminateJsonResponse
    {
        return self::json(Response::HTTP_INTERNAL_SERVER_ERROR, $message);
    }

    public static function notFound(string $message): IlluminateJsonResponse
    {
        return self::json(Response::HTTP_NOT_FOUND, $message);
    }

    public static function unprocessableEntity(string $message): IlluminateJsonResponse
    {
        return self::json(Response::HTTP_UNPROCESSABLE_ENTITY, $message);
    }

    public static function json(int $statusCode, string $message, array $data = []): IlluminateJsonResponse
    {
        return response([
            'success' => $statusCode >= 200 && $statusCode <= 299,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
