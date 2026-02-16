<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class JsonExceptionRenderer
{
    public function __invoke(Throwable $e, $request)
    {
        if (!$request->expectsJson()) {
            return null;
        }

        return match (true) {
            $e instanceof AuthenticationException => response()->json([
                'success' => false,
                'message' => 'Kamu harus login untuk mengakses.',
            ], 401),

            $e instanceof AuthorizationException => response()->json([
                'success' => false,
                'message' => 'Kamu tidak memiliki izin untuk melakukan aksi ini.',
            ], 403),

            $e instanceof NotFoundHttpException => response()->json([
                'success' => false,
                'message' => 'Endpoint tidak ditemukan.',
            ], 404),

            $e instanceof ValidationException => response()->json([
                'success' => false,
                'message' => 'Data tidak valid.',
                'errors' => $e->errors(),
            ], 422),

            default => !$e instanceof HttpExceptionInterface
                ? response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan pada server.',
                    'error' => config('app.debug') ? $e->getMessage() : null,
                ], 500)
                : null,
        };
    }
}
