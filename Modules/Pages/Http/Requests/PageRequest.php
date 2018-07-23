<?php

    namespace Modules\Pages\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class PageRequest extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules ()
        {
            switch ($this->method()) {
                case 'POST':
                    $title = 'required|unique:pages,title';
                    break;
                case 'PUT':
                    $id    = $this->route()->parameter('id');
                    $title = 'required|unique:pages,title,' . $id;
                    break;
            }

            return [
                'status_id' => 'required',
                'parent_id' => 'required',
                'title'     => $title
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
    }
