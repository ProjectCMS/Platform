<?php

    namespace Modules\Posts\Providers;

    use Illuminate\Support\ServiceProvider;
    use Illuminate\Database\Eloquent\Factory;
    use Illuminate\Contracts\Events\Dispatcher;
    use Modules\Dashboard\Events\BuildingMenu;

    class PostsServiceProvider extends ServiceProvider {
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
                    'text'    => 'Blog',
                    'icon'    => 'dripicons-feed',
                    'url'     => route('admin.posts'),
                    'order'   => 1,
                    'submenu' => [
                        [
                            'text' => 'Listar tudo',
                            'url'  => route('admin.posts')
                        ],
                        [
                            'text' => 'Adicionar novo',
                            'url'  => route('admin.posts.create'),
                        ],
                        [
                            'text' => 'Categorias',
                            'url'  => route('admin.categories'),
                        ],
                        [
                            'text' => 'Tags',
                            'url'  => route('admin.tags'),
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
                __DIR__ . '/../Config/config.php' => config_path('posts.php'),
            ], 'config');
            $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'posts');
        }

        /**
         * Register views.
         *
         * @return void
         */
        public function registerViews ()
        {
            $viewPath = resource_path('views/modules/posts');

            $sourcePath = __DIR__ . '/../Resources/views';

            $this->publishes([
                $sourcePath => $viewPath
            ], 'views');

            $this->loadViewsFrom(array_merge(array_map(function($path) {
                return $path . '/modules/posts';
            }, \Config::get('view.paths')), [$sourcePath]), 'posts');
        }

        /**
         * Register translations.
         *
         * @return void
         */
        public function registerTranslations ()
        {
            $langPath = resource_path('lang/modules/posts');

            if (is_dir($langPath)) {
                $this->loadTranslationsFrom($langPath, 'posts');
            } else {
                $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'posts');
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
         * Get the services provided by the provider.
         *
         * @return array
         */
        public function provides ()
        {
            return [];
        }

        /**
         * Register default routes
         */
        public function registerRoutes ()
        {
            /** @var Router $router */
            $router = app()->make('router');

            try {

                /** @var $posts */
                $posts = \Modules\Posts\Entities\Post::all();

                $router->group([
                    'middleware' => ['web', 'theme_web'],
                    'namespace'  => 'Modules\Posts\Http\Controllers\Web',
                    'as'         => 'web.'
                ], function() use ($router, $posts) {

                    $posts->each(function($post) use ($router) {

                        $year  = $post->created_at->format('Y');
                        $month = $post->created_at->format('m');
                        $day   = $post->created_at->format('d');

                        $router->get("{$post->id}-{$post->slug}", 'PostsController@show')
                               ->name('posts.' . $post->slug)
                               ->defaults('post', $post);

                        $router->get("{$year}/{$month}/{$day}/{$post->slug}", 'PostsController@show')
                               ->name('posts.date.' . $post->slug)
                               ->defaults('post', $post);
                    });

                });

            } catch (\Exception $e) {

            }
        }

        /**
         * Register an additional composer.
         *
         * @return void
         */
        public function registerComposers ()
        {
            $outherPosts   = NULL;
            $postsCategory = NULL;
            $tags          = NULL;

            view()->composer('*', function($view) use ($postsCategory) {

                $postsCategory = \Modules\Posts\Entities\Category::withCount('posts')->with([
                    'posts.images',
                    'posts.categories'
                ])->orderBy('posts_count', 'DESC')->take(3)->get();

                $view->with('postsCategory', $postsCategory);
            });

            view()->composer('*', function($view) use ($outherPosts) {

                $outherPosts = \Modules\Posts\Entities\Post::with('images')
                                                           ->limit(4)
                                                           ->orderBy('updated_at', 'DESC')
                                                           ->get();

                $view->with('outherPosts', $outherPosts);
            });

            view()->composer('*', function($view) use ($tags) {

                $tags = \Modules\Posts\Entities\Tag::withCount('posts')
                                                   ->limit(20)
                                                   ->orderBy('posts_count', 'DESC')
                                                   ->get();

                $view->with('tags', $tags);
            });
        }
    }
