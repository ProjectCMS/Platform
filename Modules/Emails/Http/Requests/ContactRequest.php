<?php

    namespace Modules\Emails\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class ContactRequest extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules ()
        {
            return [
                'name'                 => 'required',
                'email'                => 'required|email',
                'subject'              => 'required',
                'message'              => 'required|min:20',
                'g-recaptcha-response' => 'required|recaptcha'
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
                'g-recaptcha-response.required' => 'Por favor, certifique-se de que você é um ser humano.',
            ];
        }
    }
