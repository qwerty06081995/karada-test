<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|min:5|max:120',
            'description' => 'nullable|string',
            'status' => ['sometimes','required', Rule::in(['new','in_progress','done','archived'])],
            'priority' => 'sometimes|required|integer|min:1|max:5',
            'due_date' => 'nullable|date',
            'karada_project' => ['sometimes','required', Rule::in(['karada_u','prohuntr','other'])],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->request->remove('karada_test_label');
        $this->request->remove('importance_score');
    }
}
