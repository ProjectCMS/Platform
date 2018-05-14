<?php

    namespace Modules\Posts\Http\Controllers\admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Posts\Entities\PostImage;

    class PostImagesController extends Controller {

        public function order (Request $request, $postId)
        {
            if($request->order && $postId){
                foreach ($request->order as $key => $order){
                    $postImage = PostImage::find($order);
                    $postImage->update(['order' => $key]);
                }
            }
        }

    }
