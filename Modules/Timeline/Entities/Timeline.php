<?php

    namespace Modules\Timeline\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;
    use Modules\Core\Traits\FormatDates;

    class Timeline extends Model {

        use FormatDates;
        use Cachable;

        protected $fillable = ['title', 'content', 'post_id'];


        public function post ()
        {
            return $this->belongsTo('Modules\Posts\Entities\Post');
        }

    }
