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
            $postsCategory = $this->category->withCount('posts')->with([
                'posts.images',
                'posts.categories'
            ])->orderBy('posts_count', 'DESC')->take(3)->get();
            $outherPosts   = $this->post->with('images')->limit(4)->orderBy('updated_at', 'DESC')->get();
            $tags          = $this->tag->withCount('posts')->limit(20)->orderBy('posts_count', 'DESC')->get();

            $view->with('postsCategory', $postsCategory);
            $view->with('outherPosts', $outherPosts);
            $view->with('tags', $tags);

        }

    }