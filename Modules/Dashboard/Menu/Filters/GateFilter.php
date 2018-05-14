<?php

    namespace Modules\Dashboard\Menu\Filters;

    use Illuminate\Contracts\Auth\Access\Gate;
    use Modules\Dashboard\Menu\Builder;

    class GateFilter implements FilterInterface {
        protected $gate;

        public function __construct (Gate $gate)
        {
            $this->gate = $gate;
        }

        public function transform ($item, Builder $builder)
        {
            if (!$this->isVisible($item)) {
                return FALSE;
            }

            return $item;
        }

        protected function isVisible ($item)
        {
            if (!isset($item['can'])) {
                return TRUE;
            }

            if (isset($item['model'])) {
                return $this->gate->allows($item['can'], $item['model']);
            }

            return $this->gate->allows($item['can']);
        }
    }
