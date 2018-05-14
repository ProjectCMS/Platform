<?php

namespace Modules\Dashboard\Events;

use Modules\Dashboard\Menu\Builder;

class BuildingMenu
{
    public $menu;

    public function __construct(Builder $menu)
    {
        $this->menu = $menu;
    }
}
