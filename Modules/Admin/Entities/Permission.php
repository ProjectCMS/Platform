<?php

    namespace Modules\Admin\Entities;

    use Illuminate\Database\Eloquent\Model;

    class Permission extends Model {
        protected $fillable = [];

        public function roles ()
        {
            return $this->belongsToMany('Modules\Admin\Entities\Role', 'permission_roles');
        }
    }
