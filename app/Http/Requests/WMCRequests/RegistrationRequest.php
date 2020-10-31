<?php

namespace App\Http\Requests\WMCRequests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
        return [
            
             #------------ for Company Superadmin -----------------
            'name' => 'required|string',
            'email' => 'required|email|unique:waste_company_admins,email',
            'phone' => 'required|numeric|min:10|unique:waste_company_admins,phone',
            'password' => 'required|string',
          
            #------------ for Company -----------------
            'company_name' => 'required|string',
            'company_email' => 'required|email|unique:waste_companies,company_email',
            'company_address' => 'required|string',
            'logo' => 'nullable|image',
            'company_phone' => 'required|unique:waste_companies,company_phone',
            'company_purpose' => 'nullable|string'


         

    
        ];
    }
}
