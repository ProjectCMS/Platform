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

        public function model ()
        {
            return $this->morphTo();
        }

        public function addItem ($request)
        {
            $merge = collect();
            $data  = collect();

            if ($request->items) {
                foreach ($request->items as $key => $item) {

                    $collect    = collect();
                    $model_type = $item["provider_type"];
                    $model_id   = $item["item"];
                    $provider   = $model_type::where('id', $model_id)->get()->first();

                    $collect->tmp_id     = rand();
                    $collect->title      = $provider->title;
                    $collect->model_type = $model_type;
                    $collect->model_id   = $model_id;
                    $collect->model      = $provider;

                    $merge->push($collect);
                }

                $data = $merge->all();

            } else {
                $data->tmp_id     = rand();
                $data->title      = $request->title;
                $data->url        = $request->url;
                $data->model_type = NULL;
                $data             = [$data];
            }

            return $data;
        }

        public function managerItems ($menu_id, $items)
        {
            $items = ($items != NULL ? collect(json_decode($items)) : NULL);
            //            dd($items);

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
                    foreach ($insertItem as $key => $item) {
                        $item  = $items->where('id', $item)->first();
                        $order = $key + 1;

                        $modelType = ($item->elements->model_type == 'link' ? NULL : $item->elements->model_type);
                        $modelId   = (isset($item->elements->model_id) ? $item->elements->model_id : NULL);

                        $data = [
                            'menu_id'    => $menu_id,
                            'parent_id'  => 0,
                            'tmp_id'     => $item->id,
                            'title'      => (isset($item->elements->title) ? $item->elements->title : NULL),
                            'url'        => (isset($item->elements->url) ? $item->elements->url : NULL),
                            'model_type' => $modelType,
                            'model_id'   => $modelId,
                            'order'      => $max + $order,

                        ];

                        $insertItem = MenuItem::create($data);

                        if (isset($item->parent_id) && $item->parent_id != NULL) {
                            $item = MenuItem::where('tmp_id', $item->parent_id)->get()->first();
                            $insertItem->update(['parent_id' => $item->id]);
                        }
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
