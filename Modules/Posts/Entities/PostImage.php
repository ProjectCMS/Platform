<?php

    namespace Modules\Posts\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;

    class PostImage extends Model {

        use Cachable;

        protected $fillable = ['post_id', 'name', 'order'];

    }
