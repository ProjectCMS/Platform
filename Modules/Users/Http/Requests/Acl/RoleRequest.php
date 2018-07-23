<?php

    namespace Modules\Users\Http\Requests\Acl;

    use Illuminate\Foundation\Http\FormRequest;

    class RoleRequest extends FormRequest {
        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules ()
        {
            $tableNames = config('permission.table_names');

            switch ($this->method()) {
                case 'POST':
                    $name = 'required|string|unique:' . $tableNames['roles'] . ',name';
                    break;
                case 'PUT':
                    $id   = $this->route()->parameter('id');
                    $name = 'required|string|unique:' . $tableNames['roles'] . ',name,' . $id;
                    break;
            }

            return [
                'name'  => $name,
                'label' => 'required',
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
