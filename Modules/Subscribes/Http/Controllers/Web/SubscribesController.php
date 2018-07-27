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
            $client = auth()->guard('client')->user();

            if ($id && $this->cicles->find($id)) {
                $request->session()->put('subscribe_cicle', $request->id);
            } else {
                return redirect()->back();
            }

            if(!$client) {
                $request->session()->put('redirect', $request->getPathInfo());
                return redirect(route('web.clients'));
            }

            return redirect(route('web.subscribes.payment'));
        }

        public function payment (Request $request)
        {
            $cicle = $request->session()->get('subscribe_cicle');
            dump($cicle);
        }
    }
