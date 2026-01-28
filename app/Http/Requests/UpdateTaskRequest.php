<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'priority' => 'sometimes|in:Low,Medium,High',
            'status' => 'sometimes|string',
            'due_date' => 'nullable|date',
            'category' => 'sometimes|string|max:100',
            'attachment' => 'nullable|file|max:5120|mimes:jpg,png,pdf,docx',
        ];
    }
}
