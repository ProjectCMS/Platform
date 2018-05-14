<?php

    namespace Modules\Admin\Providers;

    use Illuminate\Contracts\Auth\Access\Gate as GateContract;
    use Illuminate\Support\ServiceProvider;
    use Illuminate\Database\Eloquent\Factory;
    use Illuminate\Contracts\Events\Dispatcher;
    use Modules\Dashboard\Events\BuildingMenu;
    use Modules\Admin\Entities\Admin;
    use Modules\Admin\Entities\Permission;

    class AdminServiceProvider extends ServiceProvider {
        /**
         * Indicates if loading of the provider is deferred.
         *
         * @var bool
         */
        protected $defer = FALSE;

        /**
         * Menu admin
         *
         * @param $events
         */
        private function MenuAdmin ($events)
        {
            $events->listen(BuildingMenu::class, function(BuildingMenu $event) {
                $event->menu->add([
                    'text'        => 'Administradores',
                    'icon'        => 'dripicons-user-group',
                    'url'         => route('admin.manager'),
                    'order'       => 4,
                    'submenu'     => [
                        [
                            'text' => 'Listar tudo',
                            'url'  => route('admin.manager')
                        ],
                        [
                            'text' => 'Adicionar novo',
                            'url'  => route('admin.manager.create'),
                        ],
                        [
                            'text' => 'Regras',
                            'url'  => route('admin.manager.create'),
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
        public function boot (Dispatcher $events, GateContract $gate)
        {
            $this->registerTranslations();
            $this->registerConfig();
            $this->registerViews();
            $this->registerFactories();
            $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

            /** Menu **/
            $this->MenuAdmin($events);

            /** Permissions **/
//            dump(Permission::with('roles')->get()->toArray());
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
                __DIR__ . '/../Config/config.php' => config_path('admin.php'),
            ], 'config');
            $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'admin');
        }

        /**
         * Register views.
         *
         * @return void
         */
        public function registerViews ()
        {
            $viewPath = resource_path('views/modules/admin');

            $sourcePath = __DIR__ . '/../Resources/views';

            $this->publishes([
                $sourcePath => $viewPath
            ], 'views');

            $this->loadViewsFrom(array_merge(array_map(function($path) {
                return $path . '/modules/admin';
            }, \Config::get('view.paths')), [$sourcePath]), 'admin');
        }

        /**
         * Register translations.
         *
         * @return void
         */
        public function registerTranslations ()
        {
            $langPath = resource_path('lang/modules/admin');

            if (is_dir($langPath)) {
                $this->loadTranslationsFrom($langPath, 'admin');
            } else {
                $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'admin');
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
                app(Factory::class)->load(__DIR__ . '/../Database/Factories');
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
