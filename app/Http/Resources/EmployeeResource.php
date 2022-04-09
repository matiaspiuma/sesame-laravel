<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

final class EmployeeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => (string) $this->id,
            'name' => (string) $this->name(),
            'email' => (string) $this->email(),
            'createdAt' => (string) $this->createdAt,
            'updatedAt' => (string) $this->updatedAt(),
        ];
    }
}
