<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
            'handle' => ['required', 'alpha_dash:', 'max:255', Rule::unique(User::class, 'handle')],
            'email' => ['required', 'string', 'lowercase:', 'email', 'max:255', Rule::unique(User::class, 'email')],
            'password' => ['required', 'confirmed:', 'min:8'],
            'role' => ['required', Rule::emum(UserRole::class)],
            'type' => ['nullable', Rule::enum(UserType::class)],
        ];
    }
}
