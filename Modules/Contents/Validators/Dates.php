<?php

    namespace Modules\Contents\Validators;


    use Modules\Contents\Entities\Content;

    class Dates {

        /**
         * @var Content
         */
        private $content;

        public function __construct (Content $content)
        {

            $this->content = $content;
        }

        public function validate ($attribute, $value, $parameters, $validator)
        {
            $id   = @$parameters[0];
            $data = $validator->getData();

            $checkDate = $this->content->whereDate($attribute, '>=', $data['starts_at'])
                                       ->whereDate($attribute, '<=', $data['finalized_at']);
            if ($id) {
                $checkDate = $checkDate->where('id', '!=', $id);
            }
            $checkDate = $checkDate->count();

            if ($checkDate) {
                return FALSE;
            }

            return TRUE;
        }

    }