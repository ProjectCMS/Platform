<?php

    namespace Modules\Users\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Modules\Users\Entities\User;

    class Acl {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  \Closure                 $next
         *
         * @return mixed
         */
        public function handle (Request $request, Closure $next)
        {
            $acl = User::acl($request->route()->getName());

            // Verifica se o usuário logado é um admin
            if ($acl->userAdmin == TRUE) {
                return $next($request);
            }

            // Conta o total de regras do usuário logado
            if ($acl->roles->count()) {
                return $next($request);

            }
            // Conta o total de permissões do usuário logado
            if ($acl->permissions->count()) {
                return $next($request);
            }

            return abort('401');


        }
    }
