<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserStatusMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->status) {
            return $next($request); // User is active, allow access to the next page
        }

        // Redirect or return an error response for inactive users
        abort(403);
    }
}
