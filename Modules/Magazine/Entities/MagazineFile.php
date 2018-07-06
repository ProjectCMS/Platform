<?php

    namespace Modules\Magazine\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;

    class MagazineFile extends Model {

        use Cachable;

        protected $hidden   = ['path'];
        protected $fillable = ['magazine_id', 'path', 'order', 'subscriber'];
        protected $appends  = ['url'];

        public function getUrlAttribute ()
        {
            /*
                Verifica se usuário está logado
            */
            if ($this->subscriber == 1 && (!auth('client')->user() && !auth('user')->user())) {
                return NULL;
            }

            return asset('storage/' . $this->path);

        }

        public function managerItems ($magazine_id, $items)
        {
            $items = ($items != NULL ? collect(json_decode($items)) : NULL);

            if ($items != NULL) {

                $magazineFiles = $this->where('magazine_id', $magazine_id);
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
                            'magazine_id' => $magazine_id,
                            'path'        => $item->path,
                            'subscriber'  => $item->subscriber,
                            'order'       => $max + $order,
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
                            'subscriber' => $item->subscriber,
                            'order'      => $order,
                        ];

                        $dd = $this->find($item->id);
                        $dd = $dd->update($data);

                    }
                }

            }

        }

    }
