<?php

    namespace Modules\Clients\Http\ViewComposers;

    use Illuminate\View\View;

    class ClientComposer {

        /**
         * Bind data to the view.
         *
         * @param  View $view
         *
         * @return void
         */
        public function compose (View $view)
        {
            $view->with('client', auth('client')->user()->load(['subscribe.cicle.period', 'subscribePayments']));
        }

    }