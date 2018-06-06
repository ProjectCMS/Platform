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
    }
