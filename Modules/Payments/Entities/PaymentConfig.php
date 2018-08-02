<?php

    namespace Modules\Payments\Entities;

    use Illuminate\Database\Eloquent\Model;

    class PaymentConfig extends Model {
        protected $fillable = ['value'];


        public function set ($key, $value)
        {
            $config = $this->whereName($key)->first();

            return $config->update(['value' => $value]) ? $value : FALSE;
        }
    }
