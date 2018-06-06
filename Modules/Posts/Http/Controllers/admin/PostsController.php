<?php

    namespace Modules\Posts\Http\Controllers\admin;

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
    use Modules\Posts\Http\Requests\Posts\CreateRequest;
    use Modules\Posts\Http\Requests\Posts\UpdateRequest;
    use Modules\Seo\Entities\Seo;

    class PostsController extends Controller {

        public function __construct (Post $post, Category $category, Seo $seo, Status $status)
        {
            $this->post     = $post;
            $this->category = $category;
            $this->seo      = $seo;
            $this->status   = $status;
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

            return view('posts::admin.posts.create', compact('status'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (CreateRequest $request)
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

            $this->post_tag($insert->id, $request->tag);
            $this->post_category($insert->id, $request->category);
            $this->post_images($insert->id, $request->images);

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
            $data   = $this->post->withTrashed()->with(['categories', 'tags', 'images'])->findOrFail($id);
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
        public function update (UpdateRequest $request, $id)
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

            $this->post_tag($id, $request->tag);
            $this->post_category($id, $request->category);
            $this->post_images($id, $request->images);

            return back()->with('status-success', 'Dados atualizado com sucesso');
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy (Request $request)
        {
            $data = $this->post->findOrFail($request->id);
            $data->categories()->forceDelete();
            $data->tags()->forceDelete();
            $data->images()->forceDelete();
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


        public function post_category ($post_id, $category)
        {
            $category     = collect($category);
            $postCategory = PostCategory::where('post_id', $post_id)->pluck('category_id');

            // Delete
            if ($postCategory->diff($category)->count()) {
                foreach ($postCategory->diff($category) as $delete) {
                    $dd = PostCategory::where('category_id', $delete);
                    $dd->forceDelete();
                }
            }
            // Insert
            if ($category->diff($postCategory)->count()) {
                foreach ($category->diff($postCategory) as $insert) {
                    PostCategory::create([
                        'post_id'     => $post_id,
                        'category_id' => $insert
                    ]);
                }
            }
        }

        public function post_tag ($post_id, $tag)
        {
            $tags    = collect($tag);
            $postTag = PostTag::where('post_id', $post_id)->pluck('tag_id');

            // Create tag
            foreach ($tags as $tag) {
                Tag::firstOrCreate(['title' => $tag], ['slug' => str_slug($tag, '-')]);
            }

            $tags = Tag::whereIn('title', $tags)->pluck('id');

            // Delete
            if ($postTag->diff($tags)->count()) {
                foreach ($postTag->diff($tags) as $delete) {
                    $dd = PostTag::where('tag_id', $delete);
                    $dd->forceDelete();
                }
            }
            // Insert
            if ($tags->diff($postTag)->count()) {
                foreach ($tags->diff($postTag) as $insert) {
                    PostTag::create([
                        'post_id' => $post_id,
                        'tag_id'  => $insert
                    ]);
                }
            }
        }

        public function post_images ($post_id, $image)
        {
            $images     = collect($image);
            $postImages = PostImage::where('post_id', $post_id);
            $max        = $postImages->max('order');

            // Delete
            if ($postImages->pluck('name')->diff($images)->count()) {
                foreach ($postImages->pluck('name')->diff($images) as $delete) {
                    $dd = PostImage::where('name', $delete);
                    $dd->forceDelete();
                }
            }
            // Insert
            if ($images->diff($postImages->pluck('name'))->count()) {
                $count = 1;
                foreach ($images->diff($postImages->pluck('name')) as $insert) {
                    PostImage::create([
                        'post_id' => $post_id,
                        'name'    => $insert,
                        'order'   => $max + $count
                    ]);
                    $count++;
                }
            }
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
