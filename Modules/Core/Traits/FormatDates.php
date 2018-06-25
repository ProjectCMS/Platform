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

        public function getCreatedAtCmAttribute ()
        {
            $this->setVariables();
            return Date::parse($this->attributes['created_at'])->format($this->cDateFormat);
        }

        public function getUpdatedAtCmAttribute ()
        {
            $this->setVariables();
            return Date::parse($this->attributes['updated_at'])->format($this->cDateFormat);
        }

        public function getDeletedAtCmAttribute ()
        {
            $this->setVariables();
            return Date::parse($this->attributes['deleted_at'])->format($this->cDateFormat);
        }

        public function getPublishAtCmAttribute ($value)
        {
            $this->setVariables();
            return Date::parse($this->attributes['publish_at'])->format($this->cDateFormat);
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