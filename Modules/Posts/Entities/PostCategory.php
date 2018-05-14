<?php

    namespace Modules\Posts\Entities;

    use Illuminate\Database\Eloquent\Model;

    class PostCategory extends Model {

        protected $fillable = ['category_id', 'post_id'];


        public function category ()
        {
            return $this->hasOne('Modules\Posts\Entities\Category', 'id', 'category_id');
        }

    }
