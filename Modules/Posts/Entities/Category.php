<?php

    namespace Modules\Posts\Entities;

    use Illuminate\Database\Eloquent\Model;

    class Category extends Model {
        protected $fillable = ['name', 'slug', 'image', 'parent_id'];

        public function setNameAttribute ($value)
        {
            $this->attributes["name"] = $value;
            $this->attributes["slug"] = str_slug($value, '-');
        }

        public function parent ()
        {
            return $this->belongsTo('Modules\Posts\Entities\Category', 'parent_id')->withDefault([
                'name' => '---',
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
            $categories = $this->withCount('posts')->with('parent')->when($request, function($query) use ($request) {

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
