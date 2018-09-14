<?php

    namespace Modules\Contents\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Contents\Entities\Content;

    class ContentsController extends Controller {

        /**
         * @var Content
         */
        private $content;

        public function __construct (Content $content)
        {
            $this->content = $content;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $paginate = $this->content->paginate(10);

            return view('contents::admin.index', compact('paginate'));
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            return view('contents::admin.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function store (Request $request)
        {
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show ()
        {
            return view('contents::show');
        }

        /**
         * Show the form for editing the specified resource.
         * @return Response
         */
        public function edit ()
        {
            return view('contents::edit');
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         *
         * @return Response
         */
        public function update (Request $request)
        {
        }

        /**
         * Remove the specified resource from storage.
         * @return Response
         */
        public function destroy ()
        {
        }
    }
