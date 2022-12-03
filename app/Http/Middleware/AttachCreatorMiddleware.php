<?php

namespace App\Http\Middleware;

use App\Models\BabySitterUser;
use App\Models\ParentUser;
use Closure;
use Illuminate\Http\Request;

class AttachCreatorMiddleware
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
        return $next($request);
    }


    /**
     * Handle response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse  $response
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function terminate(Request $request, $response)
    {
        $model = $response->original;
        if (is_array($model)) {
            $model = $model[0];
        }
        if (is_object($model) && method_exists($model, 'creator')) {
            $model->creator_id = auth()->id();
            $model->creator_type = auth()->user()->type == 'parent' ? ParentUser::class : BabySitterUser::class;
            $model->save();
        }

        return $response;
    }
}
