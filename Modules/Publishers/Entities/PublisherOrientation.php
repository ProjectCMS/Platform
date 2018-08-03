<?php

    namespace Modules\Publishers\Entities;

    use Illuminate\Database\Eloquent\Model;

    class PublisherOrientation extends Model {
        protected $fillable = [];

        public function publisher ()
        {
            return $this->hasMany('Modules\Publishers\Entities\Publisher');
        }
    }
