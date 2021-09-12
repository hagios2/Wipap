<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $validation_rules = [

            "name" => 'required|string',

            "email" => "required|email|unique:users,email",

            "phone" => "required|string|unique:users,phone",

            'location' => 'required|string',

            "password" => "required|string",

            'title' => 'required|string',

            'lat' => 'nullable',

            'long' => 'nullable',

            'digital_address' => 'nullable'
        ];

        if(request()->account_type == 'organization')
        {
            $validation_rules["organization_name"] = 'required|string';

            $validation_rules["organization_email"] = "required|email|unique:organizations,email";

            $validation_rules["organization_phone"] = "required|string|unique:organizations,phone";

            $validation_rules['logo'] = 'required|string';
        }

        return $validation_rules;
    }

}
