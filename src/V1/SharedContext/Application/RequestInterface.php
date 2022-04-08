<?php

declare(strict_types=1);

namespace Api\V1\SharedContext\Application;

interface RequestInterface
{
    public function validate(array $rules): bool;
    public function errors(): array;
}