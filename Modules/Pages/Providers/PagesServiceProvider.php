<?php

    namespace Modules\Pages\Providers;

    use Illuminate\Support\ServiceProvider;
    use Illuminate\Database\Eloquent\Factory;
    use Illuminate\Contracts\Events\Dispatcher;
    use Modules\Dashboard\Events\BuildingMenu;


    class PagesServiceProvider extends ServiceProvider {
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
                    'text'    => 'Páginas',
                    'icon'    => 'dripicons-copy',
                    'url'     => route('admin.pages'),
                    'order'   => 1,
                    'submenu' => [
                        [
                            'text' => 'Listar tudo',
                            'url'  => route('admin.pages'),
                        ],
                        [
                            'text' => 'Adicionar nova',
                            'url'  => route('admin.pages.create'),
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
            $this->registerRoutes();
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
                __DIR__ . '/../Config/config.php' => config_path('pages.php'),
            ], 'config');
            $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'pages');
        }

        /**
         * Register views.
         *
         * @return void
         */
        public function registerViews ()
        {
            $viewPath = resource_path('views/modules/pages');

            $sourcePath = __DIR__ . '/../Resources/views';

            $this->publishes([
                $sourcePath => $viewPath
            ], 'views');

            $this->loadViewsFrom(array_merge(array_map(function($path) {
                return $path . '/modules/pages';
            }, \Config::get('view.paths')), [$sourcePath]), 'pages');
        }

        /**
         * Register translations.
         *
         * @return void
         */
        public function registerTranslations ()
        {
            $langPath = resource_path('lang/modules/pages');

            if (is_dir($langPath)) {
                $this->loadTranslationsFrom($langPath, 'pages');
            } else {
                $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'pages');
            }
        }

        /**
         * Register an additional directory of factories.
         * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
         */
        public function registerFactories ()
        {
            if (!app()->environment('production')) {
                app(Factory::class)->load(__DIR__ . '/../Database/Factories');
            }
        }


        /**
         * Register default routes
         */
        public function registerRoutes ()
        {
            /** @var Router $router */
            $router = app()->make('router');

            /** @var $pages */
            $pages = \Modules\Pages\Entities\Page::all();

//            $pages->each(function($page) {
//                Route::get($page->slug, 'PagesController@show')->name('pages.' . $page->slug)->defaults('page', $page);
//            });

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
