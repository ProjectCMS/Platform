<?php

namespace Modules\Magazine\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Dashboard\Events\BuildingMenu;

class MagazineServiceProvider extends ServiceProvider
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
                'text'        => 'Revista',
                'icon'        => 'dripicons-photo-group',
                'url'         => route('admin.magazine'),
                'order'       => 3,
                'submenu'     => [
                    [
                        'text' => 'Listar tudo',
                        'url'  => route('admin.magazine'),
                    ],
                    [
                        'text' => 'Adicionar nova',
                        'url'  => route('admin.magazine.create'),
                    ],
                ],
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

        /** Menu **/
        $this->MenuAdmin($events);
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
            __DIR__.'/../Config/config.php' => config_path('magazine.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'magazine'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/magazine');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/magazine';
        }, \Config::get('view.paths')), [$sourcePath]), 'magazine');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/magazine');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'magazine');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'magazine');
        }
    }

    /**
     * Register an additional directory of factories.
     * 
     * @return void
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
