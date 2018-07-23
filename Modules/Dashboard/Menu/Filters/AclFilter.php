<?php

    namespace Modules\Dashboard\Menu\Filters;

    use Modules\Dashboard\Menu\Builder;
    use Modules\Users\Entities\User;

    class AclFilter implements FilterInterface {

        public function transform ($item, Builder $builder)
        {
            $routeCollection = \Route::getRoutes();

            $routes = [];

            foreach ($routeCollection as $key => $r) {
                $methods = $r->methods();
                if ($r->named('admin.*') && in_array('GET', $methods)) {
                    $routes[$key]['uri']  = url($r->uri());
                    $routes[$key]['name'] = $r->getName();
                }
            }

            $routes           = collect($routes);
            $route            = $routes->filter(function($value, $key) use ($item) {
                return $value['uri'] == $item['href'];
            });
            $route            = $route->values()[0];
            $acl              = User::acl($route['name']);
            $rolesCount       = $acl->roles->count();
            $permissionsCount = $acl->permissions->count();


            if ($acl->userAdmin == FALSE && $item['text'] != 'Dashboard') {
                if ($rolesCount == 0 && $permissionsCount == 0) {
                    return FALSE;
                }
            }

            return $item;
        }

    }