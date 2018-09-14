<?php

    namespace Modules\Clients\Http\Requests\Web;

    use Illuminate\Foundation\Http\FormRequest;

    class ClientRequest extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules ()
        {
            $id    = auth('client')->user()->id;
            $email = 'required|string|email|max:255|unique:clients,email,' . $id;

            return [
                'name'  => 'required',
                'email' => $email,
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
