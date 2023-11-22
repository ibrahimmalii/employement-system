<?php

namespace App\Http\Requests;

use App\Enums\RolesEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'salary' => 'required|numeric',
            'department_id' => 'required|exists:departments,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => ['required', 'min:6', 'confirmed', Password::defaults(), 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&_]/'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character.',
        ];
    }
}
