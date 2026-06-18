<?php

namespace App\Http\Requests;

use App\Enums\RecensionStatus;
use App\Enums\UserType;
use App\Models\Remark;
use App\Models\TermPaper;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRecensionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'term_paper_id' => ['required', 'integer', Rule::exists(TermPaper::class, 'id')],
            'remark_id' => ['required', 'integer', Rule::exists(Remark::class, 'id')],
            'reviewer_id' => ['required', 'integer', Rule::exists(User::class, 'id')->where('type', UserType::TEACHER->value)],
            'status' => ['required', Rule::enum(RecensionStatus::class)],
            'final_verdict' => ['required', 'string', 'max:25500'],
            'passed' => ['required', 'boolean'],
        ];
    }
}
