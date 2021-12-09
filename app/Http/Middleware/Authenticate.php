<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        if (Auth::check()) {
            if ($request->session()->has('lastOrdersTime' . Auth::user()->id)) {
                $dt = $request->session()->get('lastOrdersTime' . Auth::user()->id);
            } else {
                //dd(Auth::user()->last_login_at);
                //$dt = Carbon::today();
                $dt = Auth::user()->last_login_at != null ? Auth::user()->last_login_at : Carbon::today();
            }

            // $dt = $request->session()->get('lastOrdersTime');//"2016-11-09 17:28:59";//Carbon::now();
            $ct = \App\Order::where('created_at', '>=', $dt)->where('status', '!=', 9)->count();
            session(['newOrder' => $ct]);
        }

        return $next($request);
    }
}
