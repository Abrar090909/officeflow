<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // We use role middleware for access control
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:Low,Medium,High',
            'due_date' => 'nullable|date|after_or_equal:today',
            'category' => 'required|string|max:100',
            'attachment' => 'nullable|file|max:5120|mimes:jpg,png,pdf,docx', // Max 5MB
        ];
    }
}
