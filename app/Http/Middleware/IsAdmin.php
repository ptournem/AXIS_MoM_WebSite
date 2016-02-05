<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
	// vérifie que l'user est authentifié en admin
	if(!($request->session()->has('user')&& $request->session()->get('user')->admin==1 )){
	    if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect('/')->with('messages',['Un compte administrateur est requis pour cette action !']);
            }
	}

        return $next($request);
    }

}
