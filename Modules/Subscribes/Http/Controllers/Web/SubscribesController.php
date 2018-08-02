<?php

    namespace Modules\Subscribes\Http\Controllers\Web;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Subscribes\Entities\Subscribe;
    use Modules\Subscribes\Entities\SubscribeCicles;

    class SubscribesController extends Controller {
        /**
         * @var Subscribe
         */
        private $subscribe;
        /**
         * @var SubscribeCicles
         */
        private $cicles;

        public function __construct (Subscribe $subscribe, SubscribeCicles $cicles)
        {
            $this->subscribe = $subscribe;
            $this->cicles    = $cicles;
        }

        public function plan (Request $request, $id)
        {
            $request->session()->forget('subscribe_cicle');

            if ($id && $this->cicles->find($id)) {
                $request->session()->put('subscribe_cicle', $request->id);
            } else {
                return redirect()->back();
            }

            return redirect(route('web.subscribes.payment'));
        }

        public function payment (Request $request)
        {
            $cicle     = $request->session()->get('subscribe_cicle');
            $auth      = auth()->guard('client')->user();
            $subscribe = $this->subscribe->whereClientId($auth->id)->with(['cicle'])->get();

            if (!$cicle) {
                return redirect('/');
            }

            return view('payments::web.list');
        }
    }
