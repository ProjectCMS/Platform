<?php

    namespace Modules\Magazine\Http\ViewComposers;

    use Illuminate\View\View;
    use Modules\Magazine\Entities\Magazine;


    class MagazineComposer {

        /**
         * @var Magazine
         */
        private $magazine;

        public function __construct (Magazine $magazine)
        {
            $this->magazine = $magazine;
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
            $magazine = $this->magazine->with('files')->get();
            $view->with('magazine', $magazine);

        }

    }