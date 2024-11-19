<?php

namespace App\Http\Requests;

use App\Rules\EmailPattern;
use App\Rules\NamePattern;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class EmployeeRequest extends FormRequest
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
            'cpf' => 'required|string|size:11',
            'city' => 'required|string|between:3,120',
            'state' => 'required|string|between:3,120',
            'email' => [
                'required',
                'string',
                'email',
                new EmailPattern,
                Rule::unique('employees', 'email')
                    ->ignore($this->uuid, 'id'),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(
            [
                'cpf' => preg_replace(
                    '/\D/',
                    '',
                    $this->input('cpf')
                ),
            ]
        );
    }
}
