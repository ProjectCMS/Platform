<?php

    namespace Modules\Posts\Entities;

    use Illuminate\Database\Eloquent\Model;

    class PostImage extends Model {
        protected $fillable = ['post_id', 'name', 'order'];

//        public function getNameAttribute ($value)
//        {
//            return str_replace('\\', '/', $value);
//        }
//
//        public function setNameAttribute ($value)
//        {
//            $this->attributes['name'] = str_replace('/', '\\', $value);
//        }
    }
