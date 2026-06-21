<?php

namespace App\Http\Requests;

use App\Enums\InstitutionType;
use App\Enums\UserType;
use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UpdateInstitutionRequest extends FormRequest
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
        $institution = $this->route('institution');

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'alpha_dash',
                Rule::unique('institutions', 'slug')->ignore($institution->id),
                'max:255'],
            'type' => ['required', Rule::enum(InstitutionType::class)],
            'country_id' => ['required', 'integer', Rule::exists(Country::class, 'id')],
            'description' => ['nullable', 'string', 'max:1255'],
            'manager_id' => ['required', 'integer', Rule::exists(User::class, 'id')->where('type', UserType::TEACHER->value)],
            'logo' => ['nullable', 'image', File::image(allowSvg: true)],

        ];
    }
}
