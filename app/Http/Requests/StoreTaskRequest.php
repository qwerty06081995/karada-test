<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:5|max:120',
            'description' => 'nullable|string',
            'status' => ['required', Rule::in(['new','in_progress','done','archived'])],
            'priority' => 'required|integer|min:1|max:5',
            'due_date' => 'nullable|date',
            'karada_project' => ['required', Rule::in(['karada_u','prohuntr','other'])],
            // karada_test_label и importance_score — игнорируем, не прописываем правил
        ];
    }

    // Убираем запрещённые поля из запроса
    protected function prepareForValidation(): void
    {
        $this->request->remove('karada_test_label');
        $this->request->remove('importance_score');
    }
}
