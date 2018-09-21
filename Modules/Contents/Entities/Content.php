<?php

    namespace Modules\Contents\Entities;

    use Carbon\Carbon;
    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;
    use Modules\Core\Traits\FormatDates;

    class Content extends Model {
        use Cachable;
        use FormatDates;

        protected $fillable = ['status_id', 'title', 'slug', 'content', 'starts_at', 'finalized_at'];

        public function setTitleAttribute ($value)
        {
            $this->attributes["title"] = $value;
            $this->attributes["slug"]  = str_slug($value, '-');
        }

        public function setStartsAtAttribute ($value)
        {
            $this->attributes['starts_at'] = Carbon::parse($value)->format('Y-m-d 00:00:01');
        }

        public function setFinalizedAtAttribute ($value)
        {
            $this->attributes['finalized_at'] = Carbon::parse($value)->format('Y-m-d 23:59:59');
        }

        public function participants ()
        {
            return $this->hasMany('Modules\Contents\Entities\ContentParticipants');
        }

        public function cicles ()
        {
            return $this->hasMany('Modules\Contents\Entities\ContentCicles');
        }

    }
