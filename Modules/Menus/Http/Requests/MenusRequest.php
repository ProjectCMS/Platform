<?php

    namespace Modules\Menus\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class MenusRequest extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules ()
        {
            switch ($this->method()) {
                case 'POST':
                    $title = 'required|unique:menus,title';
                    break;
                case 'PUT':
                    $id    = $this->route()->parameter('id');
                    $title = 'required|unique:menus,title,' . $id;
                    break;
            }

            return [
                'title' => $title
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
