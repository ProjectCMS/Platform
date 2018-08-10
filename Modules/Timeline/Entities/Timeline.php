<?php

    namespace Modules\Timeline\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;
    use Modules\Core\Traits\FormatDates;

    class Timeline extends Model {

        use FormatDates;
        use Cachable;

        protected $fillable = ['title', 'content', 'post_id', 'order'];


        public function setOrderAttribute ($value)
        {
            $order                     = $this->find($value);
            $order                     = ($order->order + 1);
            $this->attributes['order'] = $order;
        }

        public function getOrderAttribute ($value)
        {
            $order = $value == 0 ? 0 : ($value - 1);
            $order = $this->whereOrder($order)->first();
            return 0;
        }

        public function post ()
        {
            return $this->belongsTo('Modules\Posts\Entities\Post');
        }

    }
