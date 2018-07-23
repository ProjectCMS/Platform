<?php

    namespace Modules\Posts\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class PostRequest extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules ()
        {
            switch ($this->method()) {
                case 'POST':
                    $title = 'required|unique:posts,title';
                    break;
                case 'PUT':
                    $id    = $this->route()->parameter('id');
                    $title = 'required|unique:posts,title,' . $id;
                    break;
            }

            return [
                'status_id' => 'required',
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
