<?php

    namespace Modules\Posts\Entities;

    use Illuminate\Database\Eloquent\Model;

    class Tag extends Model {
        protected $fillable = ['name', 'slug'];

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
