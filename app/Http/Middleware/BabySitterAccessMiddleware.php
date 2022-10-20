<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BabySitterAccessMiddleware
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
        if (auth()->user()->type == 'baby_sitter') {
            $babySitter = auth()->user();
            $baby = $request->route('baby');
            $invitation = $baby->babySitterInvitations()->where('baby_sitter_id', $babySitter->id)->latest()->first();
            if (!$invitation || !$invitation->accepted_at || $invitation->expires_at < now()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }

        return $next($request);
    }
}
