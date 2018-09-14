<?php

    namespace Modules\Pages\Http\Controllers\Web;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Pages\Entities\Page;
    use Modules\Posts\Entities\Category;
    use Modules\Posts\Entities\Post;
    use Modules\Posts\Entities\Tag;
    use Modules\Seo\Libs\Manager;

    class PagesController extends Controller {

        /**
         * @var Page
         */
        private $page;
        /**
         * @var Post
         */
        private $post;
        /**
         * @var Category
         */
        private $category;
        /**
         * @var Manager
         */
        private $seo;
        /**
         * @var Tag
         */
        private $tag;

        public function __construct (Page $page, Post $post, Category $category, Tag $tag, Manager $seo)
        {
            $this->page     = $page;
            $this->post     = $post;
            $this->category = $category;
            $this->seo      = $seo;
            $this->tag      = $tag;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $seo = $this->seo->setData();

            return view('pages::web.index', compact('seo'));
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show (Page $page)
        {
            $page = $this->page->with(['seo', 'template'])->findOrFail($page->id);
            $seo  = $this->seo->setData('page', $page);

            return view('pages::web.show', compact('page', 'seo'));
        }

        public function sitemap ()
        {
            $sitemap = $this->generateSitemap();

            return $sitemap->render('xml');
        }

        public function feed ()
        {
            $sitemap = $this->generateSitemap();

            return $sitemap->render('ror-rss');
        }

        public function generateSitemap ()
        {
            // create new sitemap object
            $sitemap = \App::make('sitemap');
                        $sitemap->setCache('revistamamaebebe.sitemap', 60);

            $posts      = $this->post->with(['images', 'author'])->get();
            $pages      = $this->page->all();
            $categories = $this->category->all();
            $tags       = $this->tag->all();

            if (!$sitemap->isCached()) {
                $sitemap->add(url('/'), \Carbon\Carbon::now(), '1.0', 'daily', NULL, 'Home');

                foreach ($pages as $page) {
                    $sitemap->add(url($page->slug), $page->updated_at, 0.9, 'monthly', NULL, $page->title);
                }

                foreach ($posts as $post) {
                    $images = [];
                    foreach ($post->images as $image) {
                        $images[] = [
                            'url'     => asset('storage/' . $image->path),
                            'title'   => $post->title,
                            'caption' => $post->title
                        ];
                    }
                    $sitemap->add(route('web.posts.' . $post->slug), $post->updated_at, 0.9, 'monthly', $images, $post->title);
                }

                foreach ($categories as $category) {
                    $sitemap->add(route('web.posts.category', $category->slug), $category->updated_at, 0.8, 'monthly', NULL, $category->title);
                }

                foreach ($tags as $tag) {
                    $sitemap->add(route('web.posts.tag', $tag->slug), $tag->updated_at, 0.8, 'monthly', NULL, $tag->title);
                }
            }

            return $sitemap;
        }


    }
