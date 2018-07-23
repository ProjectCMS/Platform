<?php

namespace Modules\Magazine\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MagazineRequest extends FormRequest
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
                $title = 'required|unique:categories,title';
                break;
            case 'PUT':
                $id    = $this->route()->parameter('id');
                $title = 'required|unique:categories,title,' . $id;
                break;
        }

        return [
            'status_id'  => 'required',
            'title'      => $title,
            'publish_at' => 'date'
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
