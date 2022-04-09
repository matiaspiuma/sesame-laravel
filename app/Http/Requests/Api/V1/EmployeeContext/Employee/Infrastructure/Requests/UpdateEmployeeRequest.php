<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\EmployeeContext\Employee\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:employees,email',
        ];
    }
}
