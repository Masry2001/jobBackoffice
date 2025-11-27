<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow Admins
        if (auth()->user()->role === 'Admin') {
            return true;
        }

        // Allow Company-Owner updating their own company
        if (auth()->user()->role === 'Company-Owner') {
            return true;
        }

        // Other roles should not access this request
        return false;
    }

    protected function prepareForValidation()
    {
        // If Admin → route model is injected
        if ($this->route('company')) {
            $this->company = $this->route('company');
            return;
        }

        // If Company-Owner → load by ownerId
        if (auth()->user()->role === 'Company-Owner') {
            $this->company = \App\Models\Company::where('ownerId', auth()->id())->first();
        }
    }

    public function rules(): array
    {
        $companyId = $this->company?->id;
        $ownerId = $this->company?->owner?->id;

        return [
            'name' => 'bail|required|string|max:255|unique:companies,name,' . $companyId,
            'address' => 'bail|required|string|max:255',
            'industry' => 'bail|required|string|max:255',
            'website' => 'bail|nullable|string|url|max:255',

            'owner_name' => 'bail|required|string|max:255',
            'owner_email' => 'bail|required|email|max:255|unique:users,email,' . $ownerId,
            'owner_password' => 'bail|nullable|string|min:8',
        ];
    }



    public function messages(): array
    {
        return [
            // company fields
            'name.required' => 'The company name is required.',
            'name.unique' => 'The company name has already been taken.',
            'name.max' => 'The company name must not exceed 255 characters.',
            'name.string' => 'The company name must be a string.',
            'address.required' => 'The address is required.',
            'address.max' => 'The address must not exceed 255 characters.',
            'address.string' => 'The address must be a string.',
            'industry.required' => 'The industry is required.',
            'industry.max' => 'The industry must not exceed 255 characters.',
            'industry.string' => 'The industry must be a string.',
            'website.url' => 'The website must be a valid URL.',
            'website.max' => 'The website must not exceed 255 characters.',

            // owner fields
            'owner_name.required' => 'The owner name is required.',
            'owner_name.max' => 'The owner name must not exceed 255 characters.',
            'owner_name.string' => 'The owner name must be a string.',
            'owner_email.max' => 'The owner email must not exceed 255 characters.',
            'owner_email.required' => 'The owner email is required.',
            'owner_email.email' => 'The owner email must be a valid email address.',
            'owner_email.unique' => 'The owner email has already been taken.',
            'owner_password.required' => 'The owner password is required.',
            'owner_password.min' => 'The owner password must be at least 8 characters long.',
            'owner_password.max' => 'The owner password must not exceed 255 characters.',
        ];
    }



}