<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

class AuthExeption extends \Exception
{
    public function render(): JsonResponse
    {
        return response()->json(['error' => ['code' => 403, 'message' => 'Login failed']], 403);
    }
}
