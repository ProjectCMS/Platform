<?php

    namespace Modules\Tracker\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use PragmaRX\Tracker\Support\Minutes;
    use Tracker;

    class TrackerController extends Controller {


        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            $range = new Minutes();
            $range->setStart(\Carbon\Carbon::now()->subDays(5));
            $range->setEnd(\Carbon\Carbon::now()->subDays(1));
            $devices = Tracker::userDevices($range);
            dump($range);
        }

        /**
         * Show the form for creating a new resource.
         * @return Response
         */
        public function create ()
        {
            return view('tracker::create');
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
            return view('tracker::show');
        }

        /**
         * Show the form for editing the specified resource.
         * @return Response
         */
        public function edit ()
        {
            return view('tracker::edit');
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
