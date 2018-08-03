<?php

    namespace Modules\Publishers\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class PublisherRequest extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules ()
        {
            switch ($this->method()) {
                case 'POST':
                    $title = 'required|unique:publishers,title';
                    break;
                case 'PUT':
                    $id    = $this->route()->parameter('id');
                    $title = 'required|unique:publishers,title,' . $id;
                    break;
            }

            return [
                'orientation_id' => 'required',
                'status_id'      => 'required',
                'url'            => 'required|url',
                'image'          => 'required',
                'title'          => $title
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
        public function messages()
        {
            return [
                'image.required' => 'Selecione uma imagem!',
            ];
        }
    }
