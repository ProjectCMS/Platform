<?php

    namespace Modules\Clients\Providers;

    use Illuminate\Routing\Router;
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Support\ServiceProvider;
    use Illuminate\Database\Eloquent\Factory;
    use Illuminate\Contracts\Events\Dispatcher;
    use Modules\Dashboard\Events\BuildingMenu;

    class ClientsServiceProvider extends ServiceProvider {
        /**
         * Indicates if loading of the provider is deferred.
         *
         * @var bool
         */
        protected $defer = FALSE;

        /**
         * The filters base class name.
         *
         * @var array
         */
        protected $middleware = [
            'client'       => \Modules\Clients\Http\Middleware\RedirectIfNotClient::class,
            'client.guest' => \Modules\Clients\Http\Middleware\RedirectIfClient::class,
        ];

        /**
         * Menu admin
         *
         * @param $events
         */
        private function MenuAdmin ($events)
        {
            $events->listen(BuildingMenu::class, function(BuildingMenu $event) {
                $event->menu->add([
                    'text'    => 'Clientes',
                    'icon'    => 'dripicons-user-group',
                    'url'     => route('admin.clients'),
                    'order'   => 5,
                    'submenu' => [
                        [
                            'text' => 'Listar tudo',
                            'url'  => route('admin.clients')
                        ],
                        [
                            'text' => 'Adicionar novo',
                            'url'  => route('admin.clients.create'),
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
        public function boot (Dispatcher $events)
        {
            $this->registerTranslations();
            $this->registerConfig();
            $this->registerViews();
            $this->registerFactories();
            $this->registerComposers();
            $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
            $this->registerMiddleware($this->app['router']);

            /** Menu **/
            $this->MenuAdmin($events);
        }

        /**
         * Register the service provider.
         *
         * @return void
         */
        public function register ()
        {
            //
        }

        /**
         * Register config.
         *
         * @return void
         */
        protected function registerConfig ()
        {
            $this->publishes([
                __DIR__ . '/../Config/config.php' => config_path('clients.php'),
            ], 'config');
            $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'clients');
        }

        /**
         * Register views.
         *
         * @return void
         */
        public function registerViews ()
        {
            $viewPath = resource_path('views/modules/clients');

            $sourcePath = __DIR__ . '/../Resources/views';

            $this->publishes([
                $sourcePath => $viewPath
            ], 'views');

            $this->loadViewsFrom(array_merge(array_map(function($path) {
                return $path . '/modules/clients';
            }, \Config::get('view.paths')), [$sourcePath]), 'clients');
        }

        /**
         * Register translations.
         *
         * @return void
         */
        public function registerTranslations ()
        {
            $langPath = resource_path('lang/modules/clients');

            if (is_dir($langPath)) {
                $this->loadTranslationsFrom($langPath, 'clients');
            } else {
                $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'clients');
            }
        }

        /**
         * Register an additional directory of factories.
         *
         * @return void
         */
        public function registerFactories ()
        {
            if (!app()->environment('production')) {
                app(Factory::class)->load(__DIR__ . '/../Database/factories');
            }
        }

        /**
         * Register the filters.
         *
         * @param  Router $router
         *
         * @return void
         */
        public function registerMiddleware (Router $router)
        {
            foreach ($this->middleware as $name => $class) {
                $router->aliasMiddleware($name, $class);
            }
        }

        /**
         * Get the services provided by the provider.
         *
         * @return array
         */
        public function provides ()
        {
            return [];
        }

        /**
         * Register an additional composer.
         *
         * @return void
         */
        public function registerComposers ()
        {
            $client = auth('client');
            view()->composer('*', function($view) use ($client) {
                $view->with('client', $client->user());
            });
        }
    }
