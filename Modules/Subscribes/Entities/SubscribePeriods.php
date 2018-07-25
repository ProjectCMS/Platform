<?php

    namespace Modules\Subscribes\Entities;

    use Illuminate\Database\Eloquent\Model;

    class SubscribePeriods extends Model {
        protected $fillable = [];

        public function cicles ()
        {
            return $this->belongsTo('Modules\Subscribes\Entities\SubscribeCicles');
        }

        public function getExtendDaysAttribute ($value)
        {
            if ($value == 0) {
                $return = 'Vitalício';
            } elseif ($value <= 30) {
                $return = $value == 1 ? $value . ' dia' : $value . ' dias';
            } else {
                $month  = round(($value / 30));
                $return = $month . ' meses';
            }

            return $return;
        }
    }
