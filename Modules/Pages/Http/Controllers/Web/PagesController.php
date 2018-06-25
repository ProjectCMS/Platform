<?php

    namespace Modules\Pages\Http\Controllers\Web;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Pages\Entities\Page;
    use Modules\Posts\Entities\Category;
    use Modules\Posts\Entities\Post;
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

        public function __construct (Page $page, Post $post, Category $category, Manager $seo)
        {
            $this->page     = $page;
            $this->post     = $post;
            $this->category = $category;
            $this->seo      = $seo;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $seo = $this->seo->setData();
            $postsFixed = $this->post->with(['images', 'categories'])->where('status_id', 2)->get();
            $postsMain  = $this->post->with(['images', 'categories'])
                                     ->where('status_id', 1)
                                     ->orderBy('updated_at', 'DESC')
                                     ->take(14)
                                     ->get();

            return view('pages::web.index', compact('postsFixed', 'postsMain'));
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show (Page $page)
        {
            $page = $this->page->findOrFail($page->id);
            $seo  = $this->seo->setData('page', $page);
            return view('pages::web.show', compact('page'));
        }


    }
