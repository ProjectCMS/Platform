<?php

    //** Register Menus **//
    if (!function_exists('register_nav_menus')) {

        function register_nav_menus ($menus)
        {
            global $menus_registred;
            $menus_registred = array_merge((array)$menus_registred, $menus);
        }
    }

    //** Get Menus Registered **//
    if (!function_exists('get_registered_nav_menus')) {

        function get_registered_nav_menus ()
        {
            global $menus_registred;

            if (isset($menus_registred)) {
                $menus_registred = (object)$menus_registred;
                $new_menu        = [];
                foreach ($menus_registred as $key => $menu) {
                    $new_menu[$key]["key"]  = $key;
                    $new_menu[$key]["name"] = $menu;
                    $new_menu[$key]         = (object)$new_menu[$key];
                }

                return $new_menu;
            }

            return [];
        }
    }

    //** Get Menus Registered **//
    if (!function_exists('get_menus')) {

        function get_menus ($location = NULL)
        {
            $value = \Modules\Menus\Entities\MenuLocation::with(['items', 'items.children'])->get();
            if ($location) {
                $value = $value->where('location', $location)->first();
            }

            return $value;
        }
    }