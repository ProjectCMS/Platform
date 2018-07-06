<?php

    namespace Modules\Magazine\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;
    use Modules\Core\Traits\FormatDates;

    class Magazine extends Model {

        use FormatDates;
        use Cachable;

        protected $fillable = ['title', 'image', 'status_id', 'publish_at'];

        public function status ()
        {
            return $this->belongsTo('Modules\Core\Entities\Status');
        }

        public function files ()
        {
            return $this->hasMany('Modules\Magazine\Entities\MagazineFile')->orderBy('order', 'ASC');
        }
    }
