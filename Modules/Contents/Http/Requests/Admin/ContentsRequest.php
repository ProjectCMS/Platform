<?php

    namespace Modules\Contents\Http\Requests\Admin;

    use Illuminate\Foundation\Http\FormRequest;

    class ContentsRequest extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules ()
        {
            switch ($this->method()) {
                case 'POST':
                    $title        = 'required|unique:contents,title';
                    $starts_at    = 'required|date|dates_db';
                    $finalized_at = 'required|date|after:starts_at|dates_db';
                    break;
                case 'PUT':
                    $id           = $this->route()->parameter('id');
                    $title        = 'required|unique:contents,title,' . $id;
                    $starts_at    = 'required|date|dates_db:' . $id;
                    $finalized_at = 'required|date|after:starts_at|dates_db:' . $id;
                    break;
            }

            return [
                'starts_at'    => $starts_at,
                'finalized_at' => $finalized_at,
                'title'        => $title
            ];
        }

        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize ()
        {
            return TRUE;
        }

        /**
         * @return array
         */
        public function messages ()
        {
            return [
                'finalized_at.after' => 'O campo data de finalização deve conter uma data posterior a data de inicio.',
                '*.dates_db'         => 'Não é possivel cadastrar um novo registro com essa data.',
            ];
        }
    }
