<?php

namespace App\Http\Requests;

use App\Enums\TermPaperStatus;
use App\Enums\UserType;
use App\Models\Remark;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTermPaperRequest extends FormRequest
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
        $termPaper = $this->route('termPaper');

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'alpha_dash', 'max:255', Rule::unique('term_papers', 'slug')->ignore($termPaper->id)],
            'teacher_id' => ['required', 'integer', Rule::exists(User::class, 'id')->where('type', UserType::TEACHER->value)],
            'student_id' => ['required', 'integer', Rule::exists(User::class, 'id')->where('type', UserType::STUDENT->value)],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'status' => ['required', Rule::enum(TermPaperStatus::class)],
            'remark_id' => ['required', 'integer', Rule::exists(Remark::class, 'id')],

        ];
    }
}
