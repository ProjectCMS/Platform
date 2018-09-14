<?php

    namespace Modules\Clients\Http\Requests\Web;

    use Illuminate\Foundation\Http\FormRequest;

    class PasswordRequest extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules ()
        {
            return [
                'current_password' => 'required',
                'new_password'     => 'required|string|min:6|confirmed',
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
                'current_password.required' => 'O campo senha atual é obrigatório',
                'new_password.required'     => 'O campo nova senha é obrigatório',
            ];
        }
    }
