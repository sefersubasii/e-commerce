<?php

namespace App\Http\Middleware;

use Closure;

class PageOneRemoveFormQueryString
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->has('page') && $request->get('page') == 1){
            return redirect()->to($request->url(), 301);
        }

        return $next($request);
    }
}
