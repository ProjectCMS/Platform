<?php

    namespace Modules\Magazine\Http\Controllers\Web;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Magazine\Entities\Magazine;

    class MagazineController extends Controller {

        /**
         * @var Magazine
         */
        private $magazine;

        public function __construct (Magazine $magazine)
        {
            $this->magazine = $magazine;
        }

        /**
         * Display a listing of the resource.
         * @return Response
         */
        public function index ()
        {
            return view('magazine::index');
        }

        /**
         * Show the specified resource.
         * @return Response
         */
        public function show (Request $request)
        {
            if($request->id) {
                $magazine = $this->magazine->whereId($request->id)->with('files')->get()->first();

                return $magazine;
            }

        }

        public function premium ()
        {
            return view('magazine::web.premium');
        }

    }
