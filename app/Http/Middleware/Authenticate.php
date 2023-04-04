<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthExeption;
use App\Exceptions\Handler;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function unauthenticated($request, array $guards)
    {
        throw new AuthExeption();
    }
}
