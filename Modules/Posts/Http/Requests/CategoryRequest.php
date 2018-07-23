<?php

    namespace Modules\Posts\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class CategoryRequest extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules ()
        {
            switch ($this->method()) {
                case 'POST':
                    $title = 'required|unique:categories,title';
                    break;
                case 'PUT':
                    $id    = $this->route()->parameter('id');
                    $title = 'required|unique:categories,title,' . $id;
                    break;
            }

            return [
                'title'     => $title,
                'parent_id' => 'required'
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
