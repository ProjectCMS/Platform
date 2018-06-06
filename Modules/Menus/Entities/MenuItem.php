<?php

    namespace Modules\Menus\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;

    class MenuItem extends Model {

        use Cachable;

        protected $fillable = [
            'menu_id',
            'tmp_id',
            'parent_id',
            'title',
            'icon',
            'url',
            'model_type',
            'model_id',
            'order'
        ];

        public $models = [
            'pages'      => '\Modules\Pages\Entities\Page',
            'categories' => '\Modules\Posts\Entities\Category',
        ];


        public function children ()
        {
            return $this->hasMany('Modules\Menus\Entities\MenuItem', 'parent_id', 'id')
                        ->with('children')
                        ->orderBy('order', 'asc');
        }

        public function parent ()
        {
            return $this->belongsTo('Modules\Menus\Entities\MenuItem', 'parent_id');
        }

        public function mdl ()
        {
            $model = (isset($this->models[$this->model_type]) ? $this->models[$this->model_type] : FALSE);
            if ($model != FALSE) {
                return $this->belongsTo($model, 'model_id', 'id');
            }
        }

        public function addItem ($request)
        {
            $merge = collect();
            $data  = collect();

            if ($request->items) {
                foreach ($request->items as $key => $item) {

                    $collect = collect();

                    $model = (isset($this->models[$item["model_type"]]) ? $this->models[$item["model_type"]] : FALSE);
                    $model = $model::where('id', $item["item"])->get()->first();

                    $collect->tmp_id     = rand();
                    $collect->title      = $model->title;
                    $collect->model_type = $item["model_type"];
                    $collect->mdl        = $model;

                    $merge->push($collect);
                }

                $data = $merge->all();

            } else {
                $data->tmp_id     = rand();
                $data->title      = $request->title;
                $data->url        = $request->url;
                $data->model_type = 'link';
                $data             = [$data];
            }

            return $data;
        }

        public function managerItems ($menu_id, $items)
        {
            $items = ($items != NULL ? collect(json_decode($items)) : NULL);

            if ($items != NULL) {

                $menuItems = MenuItem::where('menu_id', $menu_id);
                $max       = $menuItems->max('order');

                $deleteItem = $menuItems->pluck('id')->diff($items->pluck('id'));
                $insertItem = $items->pluck('id')->diff($menuItems->pluck('id'));
                $update     = $items->pluck('id')->diff($deleteItem->merge($insertItem));

                // Delete item
                if ($deleteItem->count()) {
                    foreach ($deleteItem as $item) {
                        $dd = MenuItem::where('id', $item);
                        $dd->forceDelete();
                    }
                }

                // Insert item
                if ($insertItem->count()) {
                    foreach ($insertItem as $item) {
                        $item  = $items->where('id', $item)->first();
                        $count = 1;

                        $data = [
                            'menu_id'    => $menu_id,
                            'parent_id'  => 0,
                            'tmp_id'     => $item->id,
                            'title'      => (isset($item->elements->title) ? $item->elements->title : NULL),
                            'url'        => (isset($item->elements->url) ? $item->elements->url : NULL),
                            'model_type' => (isset($item->elements->model_type) ? $item->elements->model_type : NULL),
                            'model_id'   => (isset($item->elements->model_id) ? $item->elements->model_id : NULL),
                            'order'      => $max + $count,

                        ];

                        $insertItem = MenuItem::create($data);

                        if (isset($item->parent_id) && $item->parent_id != NULL) {
                            $item = MenuItem::where('tmp_id', $item->parent_id)->get()->first();
                            $insertItem->update(['parent_id' => $item->id]);
                        }
                        $count++;
                    }
                }

                // Update item
                if ($update->count()) {
                    foreach ($items as $key => $item) {
                        $order = $key + 1;

                        if (isset($item->parent_id)) {
                            $i = MenuItem::where(function($query) use ($item) {
                                $query->where('id', $item->parent_id)->orWhere('tmp_id', $item->parent_id);
                            })->get()->first();

                            $parent_id = $i->id;
                        } else {
                            $parent_id = 0;
                        }

                        $data = [
                            'parent_id' => $parent_id,
                            'tmp_id'    => $item->id,
                            'title'     => (isset($item->elements->title) ? $item->elements->title : NULL),
                            'url'       => (isset($item->elements->url) ? $item->elements->url : NULL),
                            'order'     => $order,

                        ];

                        $dd = MenuItem::where(function($query) use ($item) {
                            $query->where('id', $item->id)->orWhere('tmp_id', $item->id);
                        });
                        $dd = $dd->update($data);

                    }
                }
            }
        }
    }
