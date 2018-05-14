<?php

    namespace Modules\Dashboard\Menu\Filters;

    use Modules\Dashboard\Menu\Builder;

    interface FilterInterface {
        public function transform ($item, Builder $builder);
    }
