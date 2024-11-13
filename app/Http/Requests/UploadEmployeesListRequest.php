<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UploadEmployeesListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'list' => 'required|file|mimes:csv',
        ];
    }
}
