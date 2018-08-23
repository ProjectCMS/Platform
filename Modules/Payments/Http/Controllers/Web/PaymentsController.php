<?php

    namespace Modules\Payments\Http\Controllers\Web;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;

    class PaymentsController extends Controller {

        public function payment (Request $request)
        {
            $cicle     = $request->session()->get('subscribe_cicle');
            $auth      = auth()->guard('client')->user();

            if (!$cicle) {
                return redirect('/');
            }

            return view('payments::web.list');
        }

    }
