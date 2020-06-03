<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules()
    {
        if(request()->account_type == 'company')
        {
            return [

                "company_name" => 'required|string',
    
                "email" => "required|email|unique:users,email",
    
                "phone" => "required|string|unique:users,phone",

                'location' => 'required|string',
    
                "password" => "required|string"
            ];

        }else if(request()->account_type == 'personal')
        {
            return [

                "name" => 'required|string',
    
                "email" => "required|email|unique:users,email",
    
                "phone" => "required|string|unique:users,phone",

                'location' => 'required|string',
    
                "password" => "required|string"
            ];
        }
        
    }
      
}
