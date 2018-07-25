<?php

    namespace Modules\Subscribes\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class CicleRequest extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules ()
        {
            switch ($this->method()) {
                case 'POST':
                    $title = 'required|unique:subscribe_cicles,title';
                    break;
                case 'PUT':
                    $id    = $this->route()->parameter('id');
                    $title = 'required|unique:subscribe_cicles,title,' . $id;
                    break;
            }

            return [
                'title'     => $title,
                'period_id' => 'required',
                'amount'    => 'required',
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
