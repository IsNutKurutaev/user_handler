<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\UsersGroup;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasUserRole
{
    public function handle(Request $request, Closure $next, string $role, string $second_role = null)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->group->slug === $role) {
            return $next($request);
        }

        if ($second_role) {
            if ($user->group->slug === $second_role) {
                return $next($request);
            }
        }

        return response(['error' => ['code' => 403, 'message' => 'Forbidden for you!']], 403);
    }
}
