<?php

namespace App\Http\Middleware;

use Closure;

class Authenticate
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
	// on vérifie que l'utilisateur est authentifié
	if(!$request->session()->has('user')){
	    if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect('/')->with('messages',['Connection requise pour cette action !']);
            }
	}

        return $next($request);
    }
}
