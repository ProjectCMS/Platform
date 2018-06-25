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
            'provider',
            'provider_model',
            'provider_type',
            'provider_id',
            'order'
        ];

        public $providers = [
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

        public function getProviderTypeAttribute ()
        {
            $providers = collect($this->providers);

            if ($this->provider_model != NULL && $providers->search($this->provider_model, TRUE)) {
                $providerModel = $providers->search($this->provider_model);
            } else {
                $providerModel = 'link';
            }

            return $providerModel;
        }


        public function provider ()
        {
            if ($this->provider_model != NULL) {
                return $this->belongsTo($this->provider_model, 'provider_id', 'id');
            }
        }

        public function addItem ($request)
        {
            $merge = collect();
            $data  = collect();

            if ($request->items) {
                foreach ($request->items as $key => $item) {

                    $collect = collect();

                    $model    = (isset($this->providers[$item["provider_type"]]) ? $this->providers[$item["provider_type"]] : FALSE);
                    $provider = $model::where('id', $item["item"])->get()->first();

                    $collect->tmp_id         = rand();
                    $collect->title          = $provider->title;
                    $collect->provider_model = $model;
                    $collect->provider_type  = $item["provider_type"];
                    $collect->provider       = $provider;

                    $merge->push($collect);
                }

                $data = $merge->all();

            } else {
                $data->tmp_id        = rand();
                $data->title         = $request->title;
                $data->url           = $request->url;
                $data->provider_type = 'link';
                $data                = [$data];
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
                    foreach ($insertItem as $key => $item) {
                        $item  = $items->where('id', $item)->first();
                        $order = $key + 1;

                        $providerModel = ($item->elements->provider_type == 'link' ? null : $this->providers[$item->elements->provider_type]);

                        $data = [
                            'menu_id'        => $menu_id,
                            'parent_id'      => 0,
                            'tmp_id'         => $item->id,
                            'title'          => (isset($item->elements->title) ? $item->elements->title : NULL),
                            'url'            => (isset($item->elements->url) ? $item->elements->url : NULL),
                            'provider_model' => $providerModel,
                            'provider_id'    => (isset($item->elements->provider_id) ? $item->elements->provider_id : NULL),
                            'order'          => $max + $order,

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
