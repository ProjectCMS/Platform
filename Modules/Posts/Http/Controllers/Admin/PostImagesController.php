<?php

    namespace Modules\Posts\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Illuminate\Support\Facades\Storage;
    use Modules\Posts\Entities\PostImage;
    use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

    class PostImagesController extends Controller {

        /**
         * @var PostImage
         */
        private $postImage;

        public function __construct (PostImage $postImage)
        {
            $this->postImage = $postImage;
        }


        public function order (Request $request, $postId)
        {
            if ($request->order && $postId) {
                foreach ($request->order as $key => $order) {
                    $dd = $this->postImage->findOrFail($order);
                    $dd->update(['order' => $key]);
                }
            }
        }

        public function optimizer ()
        {
            $files = Storage::allFiles('');
            foreach ($files as $file) {
                if ($file != '.gitignore') {

                    $item      = storage_path('app/' . $file);
                    $info      = pathinfo($item);
                    $extension = ['png', 'jpg', 'jpeg'];

                    if (in_array($info['extension'], $extension)) {
                        if (file_exists($item)) {
                            dump(ImageOptimizer::optimize($item));
                        }
                    }
                }
            }

            //            foreach ($this->postImage->all() as $image){
            //                $file = public_path('storage/'.$image->path);
            //                if(file_exists($file)) {
            //                    dump(ImageOptimizer::optimize($file));
            //                }
            //            }
        }

    }
