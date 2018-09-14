<?php

    namespace Modules\Subscribes\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class KeysRequest extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules ()
        {
            return [
                'key' => 'required',
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
                'key.required' => 'O campo chave de assinatura é obrigatório.',
            ];
        }
    }
