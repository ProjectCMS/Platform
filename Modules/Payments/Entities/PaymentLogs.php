<?php

    namespace Modules\Payments\Entities;

    use Illuminate\Database\Eloquent\Model;

    class PaymentLogs extends Model {
        protected $fillable = [
            'model_type',
            'model_id',
            'method_id',
            'client_id',
            'token_request',
            'options',
            'message',
            'status'
        ];

        public function getOptionsAttribute ($value)
        {
            return json_decode($value);
        }

        public function model ()
        {
            return $this->morphTo();
        }

        public function method ()
        {
            return $this->belongsTo('Modules\Payments\Entities\PaymentMethod', 'method_id');
        }
    }
