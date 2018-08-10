<?php

    namespace Modules\Posts\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;

    use Illuminate\Support\Facades\Storage;
    use Modules\Core\Entities\Status;
    use Modules\Posts\Entities\Category;
    use Modules\Posts\Entities\Post;
    use Modules\Posts\Entities\PostCategory;
    use Modules\Posts\Entities\PostImage;
    use Modules\Posts\Entities\PostTag;
    use Modules\Posts\Entities\Tag;
    use Modules\Posts\Http\Requests\PostRequest;
    use Modules\Seo\Entities\Seo;
    use Modules\Timeline\Entities\Timeline;
    use Modules\Timeline\Http\Requests\TimelineRequest;

    class PostsController extends Controller {

        /**
         * @var Post
         */
        private $post;
        /**
         * @var Category
         */
        private $category;
        /**
         * @var Seo
         */
        private $seo;
        /**
         * @var Status
         */
        private $status;
        /**
         * @var PostCategory
         */
        private $postCategory;
        /**
         * @var PostTag
         */
        private $postTag;
        /**
         * @var PostImage
         */
        private $postImage;
        /**
         * @var Timeline
         */
        private $timeline;

        public function __construct (Post $post, Category $category, PostCategory $postCategory, PostTag $postTag, PostImage $postImage, Seo $seo, Timeline $timeline, Status $status)
        {
            $this->post         = $post;
            $this->category     = $category;
            $this->seo          = $seo;
            $this->status       = $status;
            $this->postCategory = $postCategory;
            $this->postTag      = $postTag;
            $this->postImage    = $postImage;
            $this->timeline     = $timeline;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index (Request $request)
        {
            $categories = $this->category->pluck('title', 'id')->prepend('Todas as categorias', '');
            $dates      = $this->post->dates()->prepend('Todas as datas', '');
            $data       = $this->post->search($request->all());
            $paginate   = $data->paginate(10);

            return view('posts::admin.posts.index', compact('paginate', 'dates', 'categories'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            $status = $this->status->pluck('title', 'id');
            $posts  = $this->post->whereStatusId(4)->pluck('title', 'id')->prepend('Todos os posts', '');

            return view('posts::admin.posts.create', compact('status', 'posts'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (PostRequest $request)
        {
            $request->request->add(['author_id' => auth()->user()->id]);
            $request->request->add(['seo_token' => bcrypt(date('Y-m-d H:i:s'))]);

            $insert = $this->post->create($request->all());
            $this->seo->create([
                'seo_token'    => $request->seo_token,
                'seo_title'    => $request->seo_title ? $request->seo_title : $request->title,
                'seo_keywords' => $request->seo_keywords,
                'seo_content'  => $request->seo_content,
            ]);

            // Verifica se é pra cadastrar uma nova timeline
            if ($request->status_id == 4) {
                $this->timeline->create([
                    'title'   => $request->timeline_title ? $request->timeline_title : $request->title,
                    'content' => $request->timeline_content,
                    'post_id' => $insert->id,
                ]);
            }

            $this->postTag->managerItems($insert->id, $request->tag);
            $this->postCategory->managerItems($insert->id, $request->category);
            $this->postImage->managerItems($insert->id, $request->images);

            return redirect(route('admin.posts.edit', $insert->id))->with('status-success', 'Postagem criada com sucesso');
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show ()
        {
            return view('posts::show');
        }

        /**
         * Show the form for editing the specified resource.
         * @return Response
         */
        public function edit ($id)
        {
            $data   = $this->post->withTrashed()
                                 ->with(['categories', 'tags', 'images', 'status', 'timeline', 'seo'])
                                 ->find($id);
            $status = $this->status->pluck('title', 'id');

            if (!$data) {
                return redirect()->route('admin.posts');
            }

            return view('posts::admin.posts.edit', compact('data', 'status'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (PostRequest $request, $id)
        {
            $data = $this->post->withTrashed()->findOrFail($id);

            $data->update($request->all());

            $this->seo->updateOrCreate([
                'seo_token' => $data->seo_token,
            ], [
                'seo_title'       => $request->seo_title ? $request->seo_title : $request->title,
                'seo_keywords'    => $request->seo_keywords,
                'seo_description' => $request->seo_description,
            ]);

            // Verifica se é pra cadastrar uma nova timeline
            if ($request->status_id == 4) {
                $this->timeline->updateOrCreate([
                    'post_id' => $id,
                ], [
                    'title'   => $request->timeline_title ? $request->timeline_title : $request->title,
                    'content' => $request->timeline_content,
                ]);
            }

            $this->postTag->managerItems($id, $request->tag);
            $this->postCategory->managerItems($id, $request->category);
            $this->postImage->managerItems($id, $request->files_items);

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = $this->post->findOrFail($request->id);
            $data->forceDelete();
        }

        /**
         * @return Response
         */
        public function trash (Request $request)
        {
            $data = $this->post->findOrFail($request->id);
            $data->delete();
            back()->with('status-info', 'Publicação enviada para lixeira');
        }

        /**
         * @return Response
         */
        public function restore (Request $request)
        {
            $data = $this->post->withTrashed()->findOrFail($request->id);
            $data->restore();
            back()->with('status-info', 'Publicação restaurada da lixeira');
        }


        public function files_xml ($type)
        {
            switch ($type) {
                case 1:
                    $this->export_tags();
                    break;
                case 2:
                    $this->export_categories();
                    break;
                case 3:
                    $this->export_posts();
                    break;
            }
        }

        public function export_posts ()
        {
            $xml = simplexml_load_file('xml/posts.xml');
            foreach ($xml->post as $key => $item) {

                $count     = 0;
                $seo_token = bcrypt(date('Y-m-d H:i:s') . rand());

                $insert = [
                    'title'      => (string)$item->title,
                    'slug'       => str_slug((string)$item->title, '-'),
                    'content'    => (string)$item->content,
                    'author_id'  => auth()->user()->id,
                    'status_id'  => 1,
                    'seo_token'  => $seo_token,
                    'created_at' => (string)$item->date,
                    'updated_at' => (string)$item->date,
                ];

                $postId = Post::create($insert)->id;

                Seo::create([
                    'seo_token' => $seo_token,
                    'seo_title' => $insert["title"],
                ]);

                foreach ($item->categories as $categories) {
                    $category = Category::where("title", $categories);
                    if ($category->count()) {
                        PostCategory::create([
                            'category_id' => $category->first()->id,
                            'post_id'     => $postId,
                        ]);
                    }
                }

                foreach ($item->tags as $tags) {
                    $tag = Tag::where("title", $tags);
                    if ($tag->count()) {
                        PostTag::create([
                            'tag_id'  => $tag->first()->id,
                            'post_id' => $postId,
                        ]);
                    }
                }


                foreach ($item->images->image_url as $key => $image) {

                    if ($image != "") {
                        $name    = substr($image, strrpos($image, '/') + 1);
                        $path    = pathinfo($name);
                        $new     = str_slug($path["filename"], '-') . '.' . $path["extension"];
                        $new     = 'images' . '/' . date("Y") . '/' . date("m") . '/' . $new;
                        $storage = 'public/' . $new;


                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $image);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 500000);

                        $result = curl_exec($ch);
                        curl_close($ch);


                        Storage::put($storage, $result);

                        PostImage::create([
                            'post_id' => $postId,
                            'name'    => $new,
                            'order'   => $count,
                        ]);


                        $count++;

                    }
                }
            }
        }

        public function export_categories ()
        {
            $xml = simplexml_load_file('xml/categories.xml');
            foreach ($xml->post as $key => $item) {
                Category::create([
                    'parent_id' => 0,
                    'title'     => $item->name,
                    'slug'      => str_slug($item->name, '-'),
                    'image'     => ''
                ]);
            }
        }

        public function export_tags ()
        {
            $xml = simplexml_load_file('xml/tags.xml');
            foreach ($xml->post as $key => $item) {
                Tag::create([
                    'title' => $item->name,
                    'slug'  => $item->slug,
                ]);
            }
        }

    }
