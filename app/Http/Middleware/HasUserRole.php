<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UsersGroup;
use Closure;
use Illuminate\Http\Request;

class HasUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $is_user_has_role = User::query()->where('api_token', $request->bearerToken())
            ->firstWhere('group_id', '=', UsersGroup::firstWhere('name', $role)->id ?? null);
        if ($is_user_has_role) {
            return $next($request);
        }
        return response(['error' => ['code' => 403, 'message' => 'Forbidden for you']],403);
    }
}
