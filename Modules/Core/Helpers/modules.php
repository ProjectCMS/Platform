<?php

    //** Check Module core **//
    if (!function_exists('core_module')) {
        function core_module (\Nwidart\Modules\Module $module)
        {
            $coreModules = array_flip(config('core.coreModules'));

            return isset($coreModules[$module->getLowerName()]);
        }
    }


    //** Get Children **//
    if (!function_exists('get_children')) {
        function get_children ($children)
        {
            foreach ($children->children as $child) {
                get_children($child);
            }
        }
    }


    //** Get setting **//
    if (!function_exists('setting')) {

        function setting ($key, $default = NULL)
        {
            $value = \Modules\Settings\Entities\Setting::get($key, $default);

            return is_null($value) ? value($default) : $value;
        }
    }

    //** Get Route group **//
    if (!function_exists('routes_group')) {

        function routes_group ()
        {
            $routeCollection = \Route::getRoutes();

            $routes = [];

            foreach ($routeCollection as $key => $r) {
                if ($r->named('admin.*')) {
                    $explode = explode('.', $r->getName());
                    if ($explode[1] != 'home') {
                        $routes[$explode[1]][$key]["uri"]  = $r->uri();
                        $routes[$explode[1]][$key]["name"] = $r->getName();
                    }
                }
            }

            return json_decode(json_encode($routes), FALSE);;
        }
    }

