<?php

    namespace Modules\Publishers\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;
    use Modules\Core\Traits\FormatDates;

    class Publisher extends Model {

        use FormatDates;
        use Cachable;

        protected $fillable = ['orientation_id', 'status_id', 'title', 'slug', 'url', 'image'];

        public function setTitleAttribute ($value)
        {
            $this->attributes["title"] = $value;
            $this->attributes["slug"]  = str_slug($value, '-');
        }

        public function getImageAttribute ($value)
        {
            if ($value != NULL) {
                return asset('storage/' . $value);
            }
        }

        public function orientation ()
        {
            return $this->belongsTo('Modules\Publishers\Entities\PublisherOrientation');
        }

        public function status ()
        {
            return $this->belongsTo('Modules\Core\Entities\Status');
        }

    }
