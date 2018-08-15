<?php

    namespace Modules\Posts\Http\ViewComposers;

    use Illuminate\View\View;
    use Modules\Posts\Entities\Category;
    use Modules\Posts\Entities\Post;
    use Modules\Posts\Entities\Tag;


    class PostComposer {

        /**
         * @var Post
         */
        private $post;
        /**
         * @var Category
         */
        private $category;
        /**
         * @var Tag
         */
        private $tag;

        public function __construct (Post $post, Category $category, Tag $tag)
        {
            $this->post     = $post;
            $this->category = $category;
            $this->tag      = $tag;
        }

        /**
         * Bind data to the view.
         *
         * @param  View $view
         *
         * @return void
         */
        public function compose (View $view)
        {
            $recentsPosts = $this->post->whereStatusId(1)
                                       ->with('images')
                                       ->limit(4)
                                       ->orderBy('created_at', 'DESC')
                                       ->get();

            $postsFixed = $this->post->with(['images', 'categories'])->where('status_id', 2)->get();

            $postsMain = $this->post->with(['images', 'categories'])
                                    ->where('status_id', 1)
                                    ->orderBy('created_at', 'DESC')
                                    ->take(14)
                                    ->get();

            $categoryPosts = $this->category->withCount('posts')->with([
                'posts.images',
                'posts.categories'
            ])->orderBy('posts_count', 'DESC')->take(3)->get();

            $tags = $this->tag->withCount('posts')->limit(20)->orderBy('posts_count', 'DESC')->get();


            $view->with('recentsPosts', $recentsPosts);
            $view->with('postsFixed', $postsFixed);
            $view->with('postsMain', $postsMain);
            $view->with('categoryPosts', $categoryPosts);
            $view->with('tags', $tags);

        }

    }