<?php

declare(strict_types=1);

namespace Api\V1\SharedContext\Infrastructure\Request;

use Api\V1\SharedContext\Application\RequestInterface;
use Illuminate\Http\Request;

final class LaravelRequest extends Request implements RequestInterface
{
    public function validate(array $rules): bool
    {
        return $this->validate($rules);
    }

    public function errors(): array
    {
        return $this->errors();
    }
}