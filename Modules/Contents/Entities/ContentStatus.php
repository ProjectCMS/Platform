<?php

    namespace Modules\Contents\Entities;

    use Illuminate\Database\Eloquent\Model;

    class ContentStatus extends Model {
        protected $fillable   = [];
        protected $table      = 'content_status';
        public    $timestamps = FALSE;
    }
