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
            if (is_null($key)) {
                return new \Modules\Settings\Entities\Setting();
            }

            if (is_array($key)) {
                return \Modules\Settings\Entities\Setting::set($key[0], $key[1]);
            }

            $value = \Modules\Settings\Entities\Setting::get($key);

            return is_null($value) ? value($default) : $value;
        }
    }

