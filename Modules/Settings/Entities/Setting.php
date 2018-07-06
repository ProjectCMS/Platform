<?php

    namespace Modules\Settings\Entities;

    use Illuminate\Database\Eloquent\Model;

    class Setting extends Model {

        protected $guarded = [];

        public static function get ($key, $default = NULL)
        {
            return \Settings::get($key, $default);
        }

        public static function set ($key, $value)
        {
            \Settings::set($key, $value);
        }

    }
