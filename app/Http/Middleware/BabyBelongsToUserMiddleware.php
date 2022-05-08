<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BabyBelongsToUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $baby = $request->route('baby');
        $user = $request->user();
        abort_if(!$baby->belongsToUser($user), 404);
        return $next($request);
    }
}
