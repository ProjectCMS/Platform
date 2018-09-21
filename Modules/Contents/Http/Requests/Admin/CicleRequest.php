<?php

    namespace Modules\Contents\Http\Requests\Admin;

    use Illuminate\Foundation\Http\FormRequest;

    class CicleRequest extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules ()
        {
            return [
                'cicle' => 'required|numeric',
                'votes' => 'required|numeric',
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
