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
            return $this->belongsToMany('Modules\Posts\Entities\Post', 'post_categories', 'category_id', 'post_id');
        }

        public function menuItem ()
        {
            return $this->belongsTo('Modules\Menus\Entities\MenuItem', 'id', 'provider_id')->where(function ($query) {
                return $query->whereProviderModel('\Modules\Posts\Entities\Category');
            });
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

        public function getRouteKeyName()
        {
            return 'slug';
        }

    }
