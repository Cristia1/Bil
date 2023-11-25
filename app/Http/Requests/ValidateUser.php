<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateUser extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user');
        $user = \App\Models\User::find($userId);
    
        return [
            'contact_name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user)],
            'phone' => 'required',
            'business_name' => 'required',
            'vat_number' => 'required',
            'address' => 'required',
        ];
    }
    

    public function messages()
    {
        return [
            'contact_name.required' => 'The Contact Name is required.',
            'email.required' => 'The E-mail is required.',
            'email.unique' => 'The E-mail must be unique.',
            'phone.required' => 'The Phone is required.',
            'phone.unique' => 'The Phone must be unique.',
            'address.required' => 'The Address is required.',
            'business_name.unique' => 'Please select a valid type (Business or Individual).',
            'vat_number.unique' => 'The VAT Number is required and should match a specific pattern.',
            'password.required' => 'The Password is required.',
        ];
    }
}
