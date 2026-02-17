<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class FormRequestSubmission extends FormRequest
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
            'assignment_id' => 'required|integer|exists:assignments,id',
            'file' => 'required|file|max:3072',
        ];
    }
}
