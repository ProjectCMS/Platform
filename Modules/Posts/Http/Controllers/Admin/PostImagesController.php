<?php

    namespace Modules\Posts\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Illuminate\Support\Facades\Storage;
    use Modules\Core\Libs\ImageCompress;
    use Modules\Posts\Entities\PostImage;
    use ImageOptimizer;

    class PostImagesController extends Controller {

        /**
         * @var PostImage
         */
        private $postImage;
        /**
         * @var ImageCompress
         */
        private $compress;

        public function __construct (PostImage $postImage, ImageCompress $compress)
        {
            $this->postImage = $postImage;
            $this->compress  = $compress;
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
                            $image_compress = $this->compress->set($item, 60, 9);
                            dump($image_compress->compress());

                        }
                    }
                }
            }
        }
    }
