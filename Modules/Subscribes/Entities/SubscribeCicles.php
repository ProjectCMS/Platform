<?php

    namespace Modules\Subscribes\Entities;

    use Illuminate\Database\Eloquent\Model;
    use Modules\Core\Traits\FormatDates;
    use Modules\Core\Traits\FormatDecimal;

    class SubscribeCicles extends Model {
        use FormatDecimal;
        use FormatDates;

        protected $fillable = ['title', 'period_id', 'amount'];
        protected $appends  = ['dicount'];

        protected $decimalsFields = [
            'amount',
        ];

        public function period ()
        {
            return $this->belongsTo('Modules\Subscribes\Entities\SubscribePeriods');
        }

        public function getDiscountAttribute ()
        {
            $month = SubscribePeriods::with('cicles')->whereDays(30);
            dump($month->get()->toArray());
//            if($this->period->days > 30 && $month->count()) {
//                dump($month);
//            }
        }


    }
