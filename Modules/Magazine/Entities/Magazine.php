<?php

    namespace Modules\Magazine\Entities;

    use Illuminate\Database\Eloquent\Model;

    class Magazine extends Model {
        protected $fillable = ['title', 'status_id', 'publish_at'];

        public function status ()
        {
            return $this->belongsTo('Modules\Core\Entities\Status');
        }
    }
