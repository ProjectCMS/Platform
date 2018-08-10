<?php

    namespace Modules\Timeline\Http\ViewComposers;

    use Illuminate\View\View;
    use Modules\Timeline\Entities\Timeline;


    class TimelineComposer {

        /**
         * @var Timeline
         */
        private $timeline;

        public function __construct (Timeline $timeline)
        {
            $this->timeline = $timeline;
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
            $timeline = $this->timeline->with('post')->orderBy('order', 'ASC')->get();
            $view->with('timeline', $timeline);

        }

    }