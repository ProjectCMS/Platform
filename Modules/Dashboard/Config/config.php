<?php

    return [
        'name' => 'Dashboard',

        /*
        |--------------------------------------------------------------------------
        | Title
        |--------------------------------------------------------------------------
        |
        | The default title of your admin panel, this goes into the title tag
        | of your page. You can override it per page with the title section.
        | You can optionally also specify a title prefix and/or postfix.
        |
        */

        'title'         => 'Revista Mamãe Bebê',
        'title_prefix'  => 'Dashboard',
        'title_postfix' => '',

        /*
        |--------------------------------------------------------------------------
        | Logo
        |--------------------------------------------------------------------------
        |
        | This logo is displayed at the upper left corner of your admin panel.
        | You can use basic HTML here if you want. The logo has also a mini
        | variant, used for the mini side bar. Make it 3 letters or so
        |
        */

        'logo' => 'Revista Mamãe Bebê',

        /*
        |--------------------------------------------------------------------------
        | URLs
        |--------------------------------------------------------------------------
        |
        | Register here your dashboard, logout, login and register URLs. The
        | logout URL automatically sends a POST request in Laravel 5.3 or higher.
        | You can set the request to a GET or POST with logout_method.
        | Set register_url to null if you don't want a register link.
        |
        */

        'dashboard_url'      => 'admin/home',
        'logout_url'         => 'admin/logout',
        'logout_method'      => '',
        'login_url'          => 'admin/login',
        'register_url'       => '',
        'password_reset_url' => 'admin/password/reset',
        'password_email_url' => 'admin/password/email',

        /*
        |--------------------------------------------------------------------------
        | Menu Items
        |--------------------------------------------------------------------------
        |
        | Specify your menu items to display in the left sidebar. Each menu item
        | should have a text and and a URL. You can also specify an icon from
        | Font Awesome. A string instead of an array represents a header in sidebar
        | layout. The 'can' is a filter on Laravel's built in Gate functionality.
        |
        */

        'menu' => [
        ],

        /*
        |--------------------------------------------------------------------------
        | Menu Filters
        |--------------------------------------------------------------------------
        |
        | Choose what filters you want to include for rendering the menu.
        | You can add your own filters to this array after you've created them.
        | You can comment out the GateFilter if you don't want to use Laravel's
        | built in Gate functionality
        |
        */

        'filters' => [
            \Modules\Dashboard\Menu\Filters\HrefFilter::class,
            \Modules\Dashboard\Menu\Filters\ActiveFilter::class,
            \Modules\Dashboard\Menu\Filters\SubmenuFilter::class,
            \Modules\Dashboard\Menu\Filters\ClassesFilter::class,
            \Modules\Dashboard\Menu\Filters\GateFilter::class,
        ],


    ];
