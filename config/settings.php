<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Settings Driver
    |--------------------------------------------------------------------------
    |
    | Default settings storage driver. Supported drivers: "json", "database"
    |
    */
    'default'   => env('SETTINGS_DRIVER', 'json'),

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Enable or disable settings cache.
    |
    */
    'cache'     => [
        'enable' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Whitelist / Blacklist
    |--------------------------------------------------------------------------
    |
    | You can whitelist or blacklist settings if you don't want them to be
    | accessible through Javcascript. Use one of the lists.
    |
    */
    'whitelist' => [],

    'blacklist' => [],

    /*
    |--------------------------------------------------------------------------
    | Settings Drivers
    |--------------------------------------------------------------------------
    |
    | Configure settings driver.
    |
    */
    'drivers'   => [
        'json'     => [
            'path' => storage_path('settings.json'),
        ],
        'database' => [
            'table' => 'settings',
        ],
    ],

];
