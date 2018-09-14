<?php

    namespace Modules\Subscribes\Entities;

    use Illuminate\Database\Eloquent\Model;

    class Subscribe extends Model {

        protected $fillable = ['client_id', 'cicle_id', 'status', 'renovation_at'];

        public function cicle ()
        {
            return $this->belongsTo('Modules\Subscribes\Entities\SubscribeCicles');
        }

        public function payment_logs ()
        {
            return $this->morphMany('Modules\Payments\Entities\PaymentLogs', 'model');
        }
    }
