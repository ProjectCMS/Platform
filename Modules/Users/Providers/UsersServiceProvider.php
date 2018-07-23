<?php

    namespace Modules\Users\Providers;

    use Illuminate\Routing\Router;
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Support\ServiceProvider;
    use Illuminate\Database\Eloquent\Factory;
    use Illuminate\Contracts\Events\Dispatcher;
    use Modules\Dashboard\Events\BuildingMenu;

    class UsersServiceProvider extends ServiceProvider {
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
            'user'       => \Modules\Users\Http\Middleware\RedirectIfNotUser::class,
            'user.guest' => \Modules\Users\Http\Middleware\RedirectIfUser::class,
            'acl'        => \Modules\Users\Http\Middleware\Acl::class,
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
                    'text'    => 'Usuários',
                    'icon'    => 'dripicons-user-group',
                    'url'     => route('admin.users'),
                    'order'   => 4,
                    'submenu' => [
                        [
                            'text' => 'Listar tudo',
                            'url'  => route('admin.users')
                        ],
                        [
                            'text' => 'Adicionar novo',
                            'url'  => route('admin.users.create'),
                        ],
                        [
                            'text' => 'Regras',
                            'url'  => route('admin.roles'),
                        ],
                        [
                            'text' => 'Permissões',
                            'url'  => route('admin.permissions'),
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
            $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
            $this->registerMiddleware($this->app['router']);
            $this->registerPolicies();

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
                __DIR__ . '/../Config/config.php' => config_path('users.php'),
            ], 'config');
            $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'users');
        }

        /**
         * Register views.
         *
         * @return void
         */
        public function registerViews ()
        {
            $viewPath = resource_path('views/modules/users');

            $sourcePath = __DIR__ . '/../Resources/views';

            $this->publishes([
                $sourcePath => $viewPath
            ], 'views');

            $this->loadViewsFrom(array_merge(array_map(function($path) {
                return $path . '/modules/users';
            }, \Config::get('view.paths')), [$sourcePath]), 'users');
        }

        /**
         * Register translations.
         *
         * @return void
         */
        public function registerTranslations ()
        {
            $langPath = resource_path('lang/modules/users');

            if (is_dir($langPath)) {
                $this->loadTranslationsFrom($langPath, 'users');
            } else {
                $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'users');
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
         * Register policies.
         *
         * @return void
         */
        public function registerPolicies ()
        {
            Gate::define('check.user', function($user, $id) {
                if ($user->isAdmin() == FALSE && ($id != $user->id)) {
                    return FALSE;
                }

                return TRUE;
            });

            Gate::define('check.delete.user', function($user, $id) {
                if ($user->isAdmin() == FALSE && ($id != $user->id)) {
                    return FALSE;
                }

                return TRUE;
            });
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
    }
