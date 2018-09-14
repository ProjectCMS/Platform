<?php

    namespace Modules\Posts\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;

    class PostImage extends Model {

        use Cachable;

        protected $fillable = ['post_id', 'path', 'order'];
        protected $appends  = ['orientation'];

        public function getOrientationAttribute ()
        {
            list($width, $height) = getimagesize(storage_path('app/public/' . $this->path));

            if ($width > $height) {
                $orientation = "landscape";
            } else {
                $orientation = "portrait";
            }

            return $orientation;
        }

        public function managerItems ($post_id, $items)
        {
            $items = ($items != NULL ? collect(json_decode($items)) : NULL);
            if ($items != NULL) {

                $magazineFiles = $this->where('post_id', $post_id);
                $max           = $magazineFiles->max('order');
                $count         = 1;

                $deleteItem = $magazineFiles->pluck('id')->diff($items->pluck('id'));
                $insertItem = $items->pluck('id')->diff($magazineFiles->pluck('id'));
                $updateItem = $items->pluck('id')->diff($deleteItem->merge($insertItem));

                // Delete item
                if ($deleteItem->count()) {
                    foreach ($deleteItem as $item) {
                        $dd = $this->where('id', $item);
                        $dd->forceDelete();
                    }
                }

                // Insert item
                if ($insertItem->count()) {
                    foreach ($insertItem as $key => $item) {
                        $item  = $items->where('id', $item)->first();
                        $order = $key + 1;
                        $data  = [
                            'post_id' => $post_id,
                            'path'    => $item->path,
                            'order'   => $max + $order,
                        ];

                        $this->create($data);

                    }
                }

                // Update item
                if ($updateItem->count()) {
                    foreach ($updateItem as $key => $item) {
                        $item  = $items->where('id', $item)->first();
                        $order = $key + 1;
                        $data  = [
                            'order' => $order,
                        ];

                        $dd = $this->find($item->id);
                        $dd = $dd->update($data);

                    }
                }
            }
        }
    }
