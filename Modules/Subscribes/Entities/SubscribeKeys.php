<?php

    namespace Modules\Subscribes\Entities;

    use Illuminate\Database\Eloquent\Model;

    class subscribeKeys extends Model {
        protected $fillable = [
            'key',
            'subscribe_cicle_id',
            'use_general',
            'use_client',
            'used',
            'status',
            'validate_at'
        ];

        public function cicle ()
        {
            return $this->belongsTo('Modules\Subscribes\Entities\SubscribeCicles', 'cicle_id', 'id');
        }
    }
