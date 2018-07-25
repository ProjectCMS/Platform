<?php

    namespace Modules\Subscribes\Http\ViewComposers;

    use Illuminate\View\View;
    use Modules\Subscribes\Entities\Subscribe;
    use Modules\Subscribes\Entities\SubscribeCicles;


    class SubscribeComposer {

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

        /**
         * Bind data to the view.
         *
         * @param  View $view
         *
         * @return void
         */
        public function compose (View $view)
        {
            $subscribesCicles = $this->cicles->with(['period'])->get();

            $view->with('subscribesCicles', $subscribesCicles);

        }

    }