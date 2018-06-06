<?php

    namespace Modules\Posts\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;

    class PostTag extends Model {

        use Cachable;

        protected $fillable = ['tag_id', 'post_id'];


        public function tag ()
        {
            return $this->hasOne('Modules\Posts\Entities\Tag', 'id', 'tag_id');
        }

    }
