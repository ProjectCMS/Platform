<?php

    namespace Modules\Settings\Providers;

    use Illuminate\Events\Dispatcher;
    use Illuminate\Support\ServiceProvider;
    use Illuminate\Database\Eloquent\Factory;
    use Modules\Dashboard\Events\BuildingMenu;
    use Config;

    class SettingsServiceProvider extends ServiceProvider {
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
                    'text'    => 'Configurações',
                    'icon'    => 'dripicons-gear',
                    'url'     => route('admin.settings.general'),
                    'order'   => 10,
                    'submenu' => [
                        [
                            'text' => 'Gerais',
                            'url'  => route('admin.settings.general'),
                        ],
                        [
                            'text' => 'Menus',
                            'url'  => route('admin.settings.menus'),
                        ],
                        [
                            'text' => 'Formas de pagamento',
                            'url'  => route('admin.settings.payments'),
                        ],
                        [
                            'text' => 'Publicidades',
                            'url'  => route('admin.settings.publishers'),
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
            $this->registerSettings();
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
                __DIR__ . '/../Config/config.php' => config_path('settings.php'),
            ], 'config');
            $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'settings');
        }

        /**
         * Register views.
         *
         * @return void
         */
        public function registerViews ()
        {
            $viewPath = resource_path('views/modules/settings');

            $sourcePath = __DIR__ . '/../Resources/views';

            $this->publishes([
                $sourcePath => $viewPath
            ], 'views');

            $this->loadViewsFrom(array_merge(array_map(function($path) {
                return $path . '/modules/settings';
            }, \Config::get('view.paths')), [$sourcePath]), 'settings');
        }

        /**
         * Register translations.
         *
         * @return void
         */
        public function registerTranslations ()
        {
            $langPath = resource_path('lang/modules/settings');

            if (is_dir($langPath)) {
                $this->loadTranslationsFrom($langPath, 'settings');
            } else {
                $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'settings');
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

        public function registerSettings ()
        {

            /** Set Default timezone */
            date_default_timezone_set(setting('timezone', config('app.timezone')));
            Config::set('app.timezone', setting('timezone', config('app.timezone')));

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
