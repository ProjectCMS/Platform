<?php

    namespace Modules\Core\Providers;

    use Illuminate\Routing\Router;
    use Illuminate\Support\ServiceProvider;
    use Illuminate\Database\Eloquent\Factory;

    class CoreServiceProvider extends ServiceProvider {
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
        ];


        /**
         * Boot the application events.
         *
         * @return void
         */
        public function boot ()
        {
            $this->registerTranslations();
            $this->registerConfig();
            $this->registerViews();
            $this->registerFactories();
            $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
            $this->registerMiddleware($this->app['router']);

        }

        /**
         * Register the service provider.
         *
         * @return void
         */
        public function register ()
        {
        }

        /**
         * Register config.
         *
         * @return void
         */
        protected function registerConfig ()
        {
            $this->publishes([
                __DIR__ . '/../Config/config.php' => config_path('core.php'),
            ], 'config');
            $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'core');
        }

        /**
         * Register views.
         *
         * @return void
         */
        public function registerViews ()
        {
            $viewPath = resource_path('views/modules/core');

            $sourcePath = __DIR__ . '/../Resources/views';

            $this->publishes([
                $sourcePath => $viewPath
            ], 'views');

            $this->loadViewsFrom(array_merge(array_map(function($path) {
                return $path . '/modules/core';
            }, \Config::get('view.paths')), [$sourcePath]), 'core');
        }

        /**
         * Register translations.
         *
         * @return void
         */
        public function registerTranslations ()
        {
            $langPath = resource_path('lang/modules/core');

            if (is_dir($langPath)) {
                $this->loadTranslationsFrom($langPath, 'core');
            } else {
                $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'core');
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
