<?php

    namespace Modules\Publishers\Http\Controllers\Web;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Publishers\Entities\Publisher;

    class PublishersController extends Controller {

        /**
         * @var Publisher
         */
        private $publisher;

        public function __construct (Publisher $publisher)
        {
            $this->publisher = $publisher;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $json = $this->publisher->orderByRaw('RAND()')->with(['orientation'])->get();
            $json = $json->groupBy('orientation.type');

            return $json;
        }

        public function redirect (Request $request)
        {
            if ($request->url && $url = $this->publisher->whereUrl($request->url)->first()) {
                $url->count_clicks = $url->count_clicks + 1;
                $url->save();

                return redirect($request->url);
            }

            return back();
        }

    }
