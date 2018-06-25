<?php

    namespace Modules\Posts\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Posts\Entities\PostImage;

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
            if($request->order && $postId){
                foreach ($request->order as $key => $order){
                    $dd = $this->postImage->findOrFail($order);
                    $dd->update(['order' => $key]);
                }
            }
        }

    }
