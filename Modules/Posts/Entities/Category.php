<?php

    namespace Modules\Posts\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;
    use Modules\Core\Traits\FormatDates;
    class Category extends Model {

        use FormatDates;
        use Cachable;

        protected static $logAttributes = ['title', 'parent_id'];
        protected static $logName       = 'Categorias';

        protected $fillable = ['title', 'slug', 'image', 'parent_id'];

        public function setTitleAttribute ($value)
        {
            $this->attributes["title"] = $value;
            $this->attributes["slug"]  = str_slug($value, '-');
        }

        public function parent ()
        {
            return $this->belongsTo('Modules\Posts\Entities\Category', 'parent_id')->withDefault([
                'title' => '---',
            ]);
        }

        public function children ()
        {
            return $this->hasMany('Modules\Posts\Entities\Category', 'parent_id', 'id');
        }

        public function posts ()
        {
            return $this->belongsTo('Modules\Posts\Entities\PostCategory', 'id', 'category_id');
        }

        public function search (Array $request)
        {
            $categories = $this->withCount('posts')->with(['parent', 'children'])->when($request, function($query) use ($request) {

                if (isset($request["sort"]) && $request["sort"] != NULL) {
                    switch ($request["sort"]) {
                        default:
                            $query->orderBy($request["sort"], $request["order"]);
                            break;
                    }
                }
            });

            return $categories;
        }

    }
