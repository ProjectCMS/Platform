<?php

    namespace Modules\Core\Traits;

    use Jenssegers\Date\Date;

    trait FormatDates {

        protected $cDateFormat;
        protected $cTimeFormat;

        private function setVariables ()
        {
            $this->cDateFormat = setting('format_date', 'd/m/Y');
            $this->cTimeFormat = setting('format_time', 'H:i:s');
        }

        public function getCreatedAtAttribute ($value)
        {
            $this->setVariables();
            return Date::parse($value)->format($this->cDateFormat);
        }

        public function getUpdatedAtAttribute ($value)
        {
            $this->setVariables();
            return Date::parse($value)->format($this->cDateFormat);
        }

        public function getDeletedAtAttribute ($value)
        {
            $this->setVariables();
            if ($value != NULL) {
                return Date::parse($value)->format($this->cDateFormat);
            }

            return NULL;
        }

        public function getPublishAtAttribute ($value)
        {
            $this->setVariables();
            return Date::parse($value)->format($this->cDateFormat);
        }

        public function getcreatedAtFullAttribute ()
        {
            $this->setVariables();
            return Date::parse($this->attributes['created_at'])->format($this->cDateFormat . ' ' . $this->cTimeFormat);
        }

        public function getupdatedAtFullAttribute ()
        {
            $this->setVariables();
            return Date::parse($this->attributes['updated_at'])->format($this->cDateFormat . ' ' . $this->cTimeFormat);
        }

        public function getDeletedAtFullAttribute ()
        {
            $this->setVariables();
            return Date::parse($this->attributes['deleted_at'])->format($this->cDateFormat . ' ' . $this->cTimeFormat);
        }

        public function getPublishAtFullAttribute ()
        {
            $this->setVariables();
            return Date::parse($this->attributes['publish_at'])->format($this->cDateFormat . ' ' . $this->cTimeFormat);
        }

    }