<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateCustomer extends FormRequest
{
            
    public static function rules(): array
    {
        return [
            'contact_name' => 'required',
            'company_name' => 'required',
            'email' => 'required',
            'vat_number' => 'required',
            'type' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'contact_name.required' => 'The contact name is required.',
            'company_name.required' => 'The company name is required.',
            'email.required' => 'The email address is required.',
            'vat_number.regex' => 'The VAT Number must contain only letters and numbers.',
            'type.in' => 'Select type (Business or Individual).',

        ];
    }
}
