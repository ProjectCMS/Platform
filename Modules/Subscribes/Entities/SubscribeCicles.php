<?php

    namespace Modules\Subscribes\Entities;

    use Illuminate\Database\Eloquent\Model;
    use Modules\Core\Traits\FormatDates;
    use Modules\Core\Traits\FormatDecimal;

    class SubscribeCicles extends Model {
        use FormatDecimal;
        use FormatDates;

        protected $fillable = ['title', 'period_id', 'amount'];
        protected $appends  = ['month_amount'];

        protected $decimalsFields = [
            'amount',
        ];

        public function period ()
        {
            return $this->belongsTo('Modules\Subscribes\Entities\SubscribePeriods');
        }

        public function getMonthAmountAttribute ()
        {
            $period      = $this->period;
            $monthAmount = NULL;
            if ($period->days >= 60) {
                $month = round(($period->days / 30));
            }

            return NULL;
        }

    }
