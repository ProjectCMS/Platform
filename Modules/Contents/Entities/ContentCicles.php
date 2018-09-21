<?php

    namespace Modules\Contents\Entities;

    use Illuminate\Database\Eloquent\Model;

    class ContentCicles extends Model {
        protected $fillable   = ['content_id', 'subscribe_cicle_id', 'votes'];
        public    $timestamps = FALSE;

        public function setCicles ($content_id, $items)
        {
            $items = ($items != NULL ? collect($items) : NULL);

            if ($items != NULL) {
                $contentSubscribes = $this->where('content_id', $content_id);
                $deleteItem        = $contentSubscribes->pluck('id')->diff($items->pluck('id'));
                $insertItem        = $items->pluck('id')->diff($contentSubscribes->pluck('id'));
            }
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
                    $item = $items->where('id', $item)->first();
                    $item = (object)$item;
                    $data = [
                        'content_id'         => $content_id,
                        'subscribe_cicle_id' => $item->subscribe_cicle_id,
                        'votes'              => $item->votes,
                    ];

                    $this->create($data);
                }
            }
        }

        public function cicle ()
        {
            return $this->hasOne('Modules\Subscribes\Entities\SubscribeCicles', 'id', 'subscribe_cicle_id');
        }

    }
