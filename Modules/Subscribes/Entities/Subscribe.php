<?php

    namespace Modules\Subscribes\Entities;

    use Illuminate\Database\Eloquent\Model;

    class Subscribe extends Model {

        protected $fillable = ['client_id', 'cicle_id', 'status', 'next_renovation'];

        public function cicle ()
        {
            return $this->belongsTo('Modules\Subscribes\Entities\SubscribeCicles');
        }

    }
