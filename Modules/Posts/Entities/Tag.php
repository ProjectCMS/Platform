<?php

    namespace Modules\Posts\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;
    use Modules\Core\Traits\FormatDates;

    class Tag extends Model {

        use FormatDates;
        use Cachable;

        protected static $logAttributes = ['title'];
        protected static $logName       = 'Tags';

        protected $fillable = ['title', 'slug'];

        public function setTitleAttribute ($value)
        {
            $this->attributes["title"] = $value;
            $this->attributes["slug"] = str_slug($value, '-');
        }

        public function posts ()
        {
            return $this->belongsTo('Modules\Posts\Entities\PostTag', 'id', 'tag_id');
        }

        public function search (Array $request)
        {

            $tags = $this->withCount('posts')->when($request, function($query) use ($request) {

                if (isset($request["sort"]) && $request["sort"] != NULL) {
                    $query->orderBy($request["sort"], $request["order"]);
                }

            });

            return $tags;
        }
    }
