<?php

namespace Modules\Timeline\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimelineRequest extends FormRequest
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
                $title = 'required|unique:timelines,post_id|unique:timelines,title';
                break;
            case 'PUT':
                $id    = $this->route()->parameter('id');
                $title = 'required|unique:timelines,post_id|unique:timelines,title,' . $id;
                break;
        }

        return [
            'title'   => $title,
            'content' => 'required|max:150',
            'post_id' => 'required'
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
