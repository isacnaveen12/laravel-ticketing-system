<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CreateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => [
                'file',
                'max:10240', // 10MB max
                'mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,zip,rar'
            ],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'subject.required' => 'Please provide a subject for your ticket.',
            'description.required' => 'Please describe your issue in detail.',
            'category_id.required' => 'Please select a category for your ticket.',
            'category_id.exists' => 'Please select a valid category.',
            'priority.required' => 'Please select a priority level.',
            'priority.in' => 'Please select a valid priority level.',
            'attachments.max' => 'You can upload a maximum of 5 files.',
            'attachments.*.max' => 'Each file must be smaller than 10MB.',
            'attachments.*.mimes' => 'Only images, PDFs, documents, and zip files are allowed.',
        ];
    }
}