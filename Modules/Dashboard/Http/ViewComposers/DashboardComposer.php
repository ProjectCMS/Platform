<?php

    namespace Modules\Dashboard\Http\ViewComposers;

    use Illuminate\View\View;
    use Modules\Dashboard\Menu\Dashboard;

    class DashboardComposer {

        /**
         * @var Dashboard
         */
        private $dashboard;

        public function __construct(Dashboard $dashboard) {
            $this->dashboard = $dashboard;
        }

        public function compose(View $view)
        {
            $view->with('dashboard', $this->dashboard);
        }

    }