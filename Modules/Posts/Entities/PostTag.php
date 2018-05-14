<?php

    namespace Modules\Posts\Entities;

    use Illuminate\Database\Eloquent\Model;

    class PostTag extends Model {

        protected $fillable = ['tag_id', 'post_id'];


        public function tag ()
        {
            return $this->hasOne('Modules\Posts\Entities\Tag', 'id', 'tag_id');
        }

    }
