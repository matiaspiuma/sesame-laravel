<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\EmployeeContext\WorkEntry\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateWorkEntryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'startDate' => 'required|date|before:now',
            'endDate' => 'required|date|after:startDate',
        ];
    }
}
