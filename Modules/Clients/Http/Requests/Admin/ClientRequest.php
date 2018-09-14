<?php

namespace Modules\Clients\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                $email = 'required|string|email|max:255|unique:clients,email';
                break;
            case 'PUT':
                $id    = $this->route()->parameter('id');
                $email = 'required|string|email|max:255|unique:clients,email,' . $id;
                break;
        }

        return [
            'name'     => 'required',
            'email'    => $email,
            'password' => 'required|string|min:6|confirmed'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
