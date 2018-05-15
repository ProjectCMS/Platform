<?php

    namespace Modules\Users\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotUser
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = 'users')
	{
	    if (!Auth::guard($guard)->check()) {
	        return redirect('admin/login');
	    }

	    return $next($request);
	}
}