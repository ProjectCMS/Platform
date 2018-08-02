<?php

    namespace Modules\Clients\Http\Middleware;

    use Closure;
    use Illuminate\Support\Facades\Auth;

    class RedirectIfNotClient {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  \Closure                 $next
         * @param  string|null              $guard
         *
         * @return mixed
         */
        public function handle ($request, Closure $next, $guard = 'client')
        {
            if (!Auth::guard($guard)->check()) {
                return redirect(route('web.clients.login'));
            }

            return $next($request);
        }
    }