<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'company_id' => ['nullable', 'exists:companies,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'email'      => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class
            ],
            'password'   => [
                'required',
                'confirmed',
                Password::defaults()
            ],
            'phone'      => ['nullable', 'string', 'max:30'],
            'terms'      => ['accepted'],
        ];
    }

    /**
     * Custom attribute names for validation error messages.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'company_id' => 'company',
            'first_name' => 'first name',
            'last_name'  => 'last name',
            'email'      => 'email address',
            'password'   => 'password',
            'terms'      => 'terms of service',
        ];
    }

    /**
     * Custom validation error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'terms.accepted'    => 'You must accept the Terms of Service to register.',
            'email.unique'      => 'This email address is already registered. Please sign in instead.',
            'company_id.exists' => 'The selected company does not exist.',
        ];
    }
}
