<?php

    namespace Modules\Publishers\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;
    use Modules\Core\Traits\FormatDates;

    class Publisher extends Model {

        use FormatDates;
        use Cachable;

        protected $fillable = ['orientation_id', 'status_id', 'title', 'slug', 'url', 'image'];
        protected $appends  = ['image_link'];

        public function setTitleAttribute ($value)
        {
            $this->attributes["title"] = $value;
            $this->attributes["slug"]  = str_slug($value, '-');
        }

        public function getImageLinkAttribute ()
        {
            if ($this->image != NULL) {
                return asset('storage/' . $this->image);
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
