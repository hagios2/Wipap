<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BinFormRequest extends FormRequest
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
        return [
            'quantity' => 'required|integer',
            'garbage_type_id' => 'required|integer',
            'bin_size' => 'nullable|string',
            'waste_company_id' => 'required|integer',
        ];
    }
}
