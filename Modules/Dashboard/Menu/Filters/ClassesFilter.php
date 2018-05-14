<?php

    namespace Modules\Dashboard\Menu\Filters;

    use Modules\Dashboard\Menu\Builder;

    class ClassesFilter implements FilterInterface {
        public function transform ($item, Builder $builder)
        {
            if (!isset($item['header'])) {
                $item['classes']         = $this->makeClasses($item);
                $item['class']           = implode(' ', $item['classes']);
                $item['top_nav_classes'] = $this->makeClasses($item, TRUE);
                $item['top_nav_class']   = implode(' ', $item['top_nav_classes']);
            }

            return $item;
        }

        protected function makeClasses ($item, $topNav = FALSE)
        {
            $classes = [];

            if ($item['active']) {
                $classes[] = 'active';
            }

            if (isset($item['submenu'])) {
                $classes[] = $topNav ? 'dropdown' : 'treeview';
            }

            return $classes;
        }
    }
