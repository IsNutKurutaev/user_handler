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
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        $user = User::firstWhere('api_token', $token);

        if($token != null && isset($user)) {
            return $next($request);
        }
        return response(new ErrorsResource(['code' => 403, 'message' => 'Login failed']), 403);
    }
}
