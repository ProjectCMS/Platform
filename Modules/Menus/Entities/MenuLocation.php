<?php

    namespace Modules\Menus\Entities;

    use GeneaLabs\LaravelModelCaching\Traits\Cachable;
    use Illuminate\Database\Eloquent\Model;

    class MenuLocation extends Model {

        use Cachable;

        protected $fillable   = ['menu_id', 'location'];
        public    $timestamps = FALSE;

        public function locations ()
        {
            $locations = get_registered_nav_menus();
            foreach ($locations as $key => $item) {
                $item->location = $this->where('location', $key)->get()->first();
            }

            return $locations;
        }

        public function items ()
        {
            return $this->hasMany('Modules\Menus\Entities\MenuItem', 'menu_id', 'menu_id')->where('parent_id', 0)->orderBy('order', 'asc');
        }
    }
