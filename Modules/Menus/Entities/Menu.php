<?php

    namespace Modules\Menus\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;


    class Menu extends Model {

        use Cachable;

        protected $fillable = ['title'];

        public function items ()
        {
            return $this->hasMany('Modules\Menus\Entities\MenuItem')->where('parent_id', 0)->orderBy('order', 'asc');
        }

    }
