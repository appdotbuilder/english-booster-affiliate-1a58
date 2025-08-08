<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:online,offline_pare,group,branch',
            'location' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'commission_percentage' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Program name is required.',
            'category.required' => 'Program category is required.',
            'category.in' => 'Invalid program category selected.',
            'price.required' => 'Program price is required.',
            'price.numeric' => 'Program price must be a valid number.',
            'commission_percentage.required' => 'Commission percentage is required.',
            'commission_percentage.numeric' => 'Commission percentage must be a valid number.',
            'commission_percentage.max' => 'Commission percentage cannot exceed 100%.',
        ];
    }
}