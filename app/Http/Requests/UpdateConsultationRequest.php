<?php

namespace App\Http\Requests;

use App\Enums\ConsultationStatus;
use App\Enums\ConsultationType;
use App\Enums\UserType;
use App\Models\TermPaper;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateConsultationRequest extends FormRequest
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
            'term_paper_id' => ['required', 'integer', Rule::exists(TermPaper::class, 'id')],
            'teacher_id' => ['required', 'integer', Rule::exists(User::class, 'id')->where('type', UserType::TEACHER->value)],
            'student_id' => ['required', 'integer', Rule::exists(User::class, 'id')->where('type', UserType::STUDENT->value)],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date'],
            'type' => ['required', Rule::enum(ConsultationType::class)],
            'status' => ['required', Rule::enum(ConsultationStatus::class)],
            'location' => ['nullable', 'string', 'max:72'],
            'notes' => ['nullable', 'string', 'max:255'],
            'attended' => ['nullable', 'boolean'],
        ];
    }
}
