<?php

    namespace Modules\Settings\Entities;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Cache;

    class Setting extends Model {

        protected $guarded    = [];
        public    $timestamps = FALSE;

        /**
         * Add a settings value
         *
         * @param        $key
         * @param        $val
         *
         * @return bool
         */
        public static function add ($key, $val)
        {
            if (self::has($key)) {
                return self::set($key, $val);
            }

            return self::create(['key' => $key, 'value' => $val]) ? $val : FALSE;
        }

        /**
         * Get a settings value
         *
         * @param      $key
         * @param null $default
         *
         * @return bool|int|mixed
         */
        public static function get ($key, $default = NULL)
        {
            if (self::has($key)) {
                $setting = self::getAllSettings()->where('key', $key)->first();

                return $setting->value;
            }

            return self::getDefaultValue($key, $default);
        }

        /**
         * Set a value for setting
         *
         * @param        $key
         * @param        $val
         * @param string $type
         *
         * @return bool
         */
        public static function set ($key, $val)
        {
            if ($setting = self::getAllSettings()->where('key', $key)->first()) {

                return $setting->update(['key' => $key, 'value' => $val]) ? $val : FALSE;
            }

            return self::add($key, $val);
        }

        /**
         * Remove a setting
         *
         * @param $key
         *
         * @return bool
         */
        public static function remove ($key)
        {
            if (self::has($key)) {
                return self::whereName($key)->delete();
            }

            return FALSE;
        }

        /**
         * Check if setting exists
         *
         * @param $key
         *
         * @return bool
         */
        public static function has ($key)
        {
            return (boolean)self::getAllSettings()->whereStrict('key', $key)->count();
        }

        /**
         * Get the data type of a setting
         *
         * @param $field
         *
         * @return mixed
         */
        public static function getDataType ($field)
        {
            $type = self::getDefinedSettingFields()->pluck('data', 'key')->get($field);

            return is_null($type) ? 'string' : $type;
        }

        /**
         * Get default value for a setting
         *
         * @param $field
         *
         * @return mixed
         */
        public static function getDefaultValueForField ($field)
        {
            return self::getDefinedSettingFields()->pluck('value', 'key')->get($field);
        }

        /**
         * Get default value from config if no value passed
         *
         * @param $key
         * @param $default
         *
         * @return mixed
         */
        private static function getDefaultValue ($key, $default)
        {
            return is_null($default) ? self::getDefaultValueForField($key) : $default;
        }

        /**
         * Get all the settings fields from config
         *
         * @return Collection
         */
        private static function getDefinedSettingFields ()
        {
            return collect(config('setting_fields'))->pluck('elements')->flatten(1);
        }

        /**
         * Get all the settings
         *
         * @return mixed
         */
        public static function getAllSettings ()
        {
            return Cache::rememberForever('settings.all', function() {
                return self::all();
            });
        }

        /**
         * Flush the cache
         */
        public static function flushCache()
        {
            Cache::forget('settings.all');
        }

        /**
         * The "booting" method of the model.
         *
         * @return void
         */
        protected static function boot()
        {
            parent::boot();

            static::updated(function () {
                self::flushCache();
            });

            static::created(function() {
                self::flushCache();
            });
        }

    }
