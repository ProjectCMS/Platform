<?php

    namespace Modules\Posts\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;

    class PostCategory extends Model {

        use Cachable;

        protected $fillable = ['category_id', 'post_id'];


        public function category ()
        {
            return $this->hasOne('Modules\Posts\Entities\Category', 'id', 'category_id');
        }

    }
