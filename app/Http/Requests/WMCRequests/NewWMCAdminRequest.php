<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewWMCAdminRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:waste_company_admins,email',
            'phone' => 'required|numeric|min:10|unique:waste_company_admins,phone',
            'role' => 'required|integer'
        ];
    }
}
