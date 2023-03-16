<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class IsUserAreAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $is_user_admin = User::query()->where('api_token', $request->bearerToken())->firstWhere('group_id', '=', 1);
        if ($is_user_admin) {
            return $next($request);
        }
        return response(['error' => ['code' => 403, 'message' => 'Forbidden for you']],403);
    }
}
