<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                $email = 'required|string|email|max:255|unique:users,email';
                break;
            case 'PUT':
                $id    = $this->route()->parameter('id');
                $email = 'required|string|email|max:255|unique:users,email,' . $id;
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
