<?php

declare(strict_types=1);

namespace Api\V1\SharedContext\Application\CQRS\Query;

interface QueryBusInterface
{
    public function execute(QueryInterface $query): mixed;
}