<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use App\Models\Country;
use App\Models\Institution;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFacultyRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'alpha_dash', 'max:255'],
            'institution_id' => ['required', 'integer', Rule::exists(Institution::class, 'id')],
            'country_id' => ['required', 'integer', Rule::exists(Country::class, 'id')],
            'dean_id' => ['required', 'integer', Rule::exists(User::class, 'id')->where('role', UserRole::DEAN->value)],
        ];
    }
}
