<?php

    namespace Modules\Dashboard\Providers;

    use Illuminate\Support\ServiceProvider;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\Config\Repository;
    use Illuminate\Contracts\Events\Dispatcher;
    use Illuminate\Contracts\Container\Container;
    use Modules\Dashboard\Events\BuildingMenu;
    use Illuminate\Support\ServiceProvider as BaseServiceProvider;
    use Modules\Dashboard\Http\ViewComposers\DashboardComposer;
    use Modules\Dashboard\Menu\Dashboard;


    class MenuServiceProvider extends ServiceProvider {
        /**
         * Indicates if loading of the provider is deferred.
         *
         * @var bool
         */
        protected $defer = FALSE;

        public function boot (Factory $view, Dispatcher $events, Repository $config)
        {
            $this->registerViewComposers($view);
            static::registerMenu($events, $config);
        }

        /**
         * Register the service provider.
         *
         * @return void
         */
        public function register ()
        {
            $this->app->singleton(Dashboard::class, function(Container $app) {
                return new Dashboard($app['config']['dashboard.filters'], $app['events'], $app);
            });
        }

        private function registerViewComposers(Factory $view)
        {
            $view->composer('dashboard::layouts.master', DashboardComposer::class);
        }

        public static function registerMenu(Dispatcher $events, Repository $config)
        {
            $events->listen(BuildingMenu::class, function (BuildingMenu $event) use ($config) {
                $menu = $config->get('dashboard.menu');
                call_user_func_array([$event->menu, 'add'], $menu);
            });
        }


    }
