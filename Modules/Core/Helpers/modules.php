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


    //** Get Children **//
    if (!function_exists('setting')) {

        function setting ($key, $default = NULL)
        {
            $value = \Modules\Settings\Entities\Setting::get($key, $default);
            return is_null($value) ? value($default) : $value;
        }
    }

