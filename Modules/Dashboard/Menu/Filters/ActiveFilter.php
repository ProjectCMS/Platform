<?php

    namespace Modules\Dashboard\Menu\Filters;

    use Modules\Dashboard\Menu\Builder;
    use Modules\Dashboard\Menu\ActiveChecker;

    class ActiveFilter implements FilterInterface {
        private $activeChecker;

        public function __construct (ActiveChecker $activeChecker)
        {
            $this->activeChecker = $activeChecker;
        }

        public function transform ($item, Builder $builder)
        {
            if (!isset($item['header'])) {
                $item['active'] = $this->activeChecker->isActive($item);
            }

            return $item;
        }
    }
