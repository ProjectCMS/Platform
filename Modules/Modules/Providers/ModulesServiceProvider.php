<?php

namespace Modules\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Contracts\Events\Dispatcher;
use Modules\Dashboard\Events\BuildingMenu;


class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Menu admin
     *
     * @param $events
     */
    private function MenuAdmin ($events)
    {
        $events->listen(BuildingMenu::class, function(BuildingMenu $event) {
            $event->menu->add([
                'text'        => 'Módulos',
                'icon'        => 'dripicons-view-thumb',
                'url'         => route('admin.modules'),
                'order'       => 10,
            ]);
            $event->menu->add([
                'text'        => 'Módulos2',
                'icon'        => 'dripicons-view-thumb',
                'url'         => route('admin.modules'),
                'order'       => 10,
            ]);
        });
    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('modules.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'modules'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/modules');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/modules';
        }, \Config::get('view.paths')), [$sourcePath]), 'modules');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/modules');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'modules');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'modules');
        }
    }

    /**
     * Register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/Factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
