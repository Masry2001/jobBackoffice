<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobVacancyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['bail', 'required', 'string', 'max:255'],
            'description' => ['bail', 'required', 'string', 'max:255'],
            'location' => ['bail', 'required', 'string', 'max:255'],
            'salary' => ['bail', 'required', 'numeric', 'min:0'],
            'type' => ['bail', 'required', 'string', 'max:255'],
            'companyId' => ['bail', 'required', 'exists:companies,id'],
            'jobCategoryId' => ['bail', 'required', 'exists:job_categories,id'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The job vacancy title is required.',
            'title.max' => 'The job vacancy title may not be greater than 255 characters.',
            'title.string' => 'The job vacancy title must be a string.',
            'description.required' => 'The job vacancy description is required.',
            'description.max' => 'The job vacancy description may not be greater than 255 characters.',
            'description.string' => 'The job vacancy description must be a string.',
            'location.max' => 'The job vacancy location may not be greater than 255 characters.',
            'location.string' => 'The job vacancy location must be a string.',
            'location.required' => 'The job vacancy location is required.',
            'salary.required' => 'The job vacancy salary is required.',
            'salary.numeric' => 'The job vacancy salary must be a number.',
            'salary.min' => 'The job vacancy salary must be at least 0.',
            'type.required' => 'The job vacancy type is required.',
            'type.string' => 'The job vacancy type must be a string.',
            'type.max' => 'The job vacancy type may not be greater than 255 characters.',
            'companyId.required' => 'The job vacancy company is required.',
            'companyId.exists' => 'The selected job company is invalid.',
            'jobCategoryId.exists' => 'The selected job category is invalid.',
            'jobCategoryId.required' => 'The job vacancy category is required.',
        ];
    }
}
