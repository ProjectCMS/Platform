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

    }
