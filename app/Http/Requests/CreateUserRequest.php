<?php

namespace App\Http\Requests;

use App\Rules\EmailPattern;
use App\Rules\NamePattern;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

final class CreateUserRequest extends FormRequest
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
     * @return array<string,array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'between:3,120', new NamePattern],
            'password' => ['required', 'confirmed', Password::min(8)],
            'email' => [
                'required',
                'string',
                'email',
                new EmailPattern,
                Rule::unique('users', 'email'),
            ],
        ];
    }
}
