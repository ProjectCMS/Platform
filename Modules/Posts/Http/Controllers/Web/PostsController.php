<?php

    namespace Modules\Posts\Http\Controllers\Web;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;

    use Modules\Posts\Entities\Category;
    use Modules\Posts\Entities\Post;
    use Modules\Posts\Entities\Tag;
    use Modules\Seo\Libs\Manager;

    class PostsController extends Controller {

        /**
         * @var Post
         */
        private $post;
        /**
         * @var WebSeo
         */
        private $seo;

        public function __construct (Post $post, Manager $seo)
        {
            $this->post = $post;
            $this->seo  = $seo;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $posts = $this->post->with(['images', 'tags', 'categories']);
            $title = 'Blog';
            $posts = $posts->whereStatusId(1)->orderBy('updated_at', 'DESC')->paginate(10);
            $seo   = $this->seo->setData('page', NULL, compact('title'));

            return view('posts::web.list', compact('posts', 'seo'));
        }

        public function tag (Tag $tag)
        {
            $data  = $tag->with(['posts'])->findOrFail($tag->id);
            $posts = $data->posts()->whereStatusId(1)->orderBy('updated_at', 'DESC')->with(['images', 'tags', 'categories'])->paginate(10);
            $seo   = $this->seo->setData('tag', $data);

            return view('posts::web.list', compact('data', 'posts', 'seo'));
        }

        public function category (Category $category)
        {
            $data  = $category->with(['posts'])->findOrFail($category->id);
            $posts = $data->posts()->whereStatusId(1)->orderBy('updated_at', 'DESC')->with(['images', 'tags', 'categories'])->paginate(10);
            $seo   = $this->seo->setData('category', $data);

            return view('posts::web.list', compact('data', 'posts', 'seo'));
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show ($post)
        {
            $post = $this->post->with(['categories', 'tags', 'images', 'seo'])->findOrFail($post->id);
            $prev = Post::where('id', '<', $post->id)->orderBy('id', 'desc')->first();
            $next = Post::where('id', '>', $post->id)->first();
            $seo  = $this->seo->setData('post', $post);

            return view('posts::web.show', compact('post', 'prev', 'next', 'seo'));
        }

    }
