<?php

namespace App\Http\Middleware;

use App\Http\Resources\ErrorsResource;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        $user = User::firstWhere('api_token', $token);

        if(isset($user)) {
            return $next($request);
        }
        return response(new ErrorsResource(['code' => 403, 'message' => 'Login failed']), 403);
    }
}
