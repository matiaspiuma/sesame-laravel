<?php

declare(strict_types=1);

namespace Api\V1\SharedContext\Infrastructure\CQRS\Query;

use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryInterface;
use Illuminate\Support\Facades\App;
use ReflectionClass;

final class LaravelQueryBus implements QueryBusInterface
{
    public function execute(QueryInterface $query): mixed
    {
        $reflection = new ReflectionClass(
            objectOrClass: $query
        );

        $handlerName = str_replace(
            search: "Query",
            replace: "QueryHandler",
            subject: $reflection->getShortName()
        );

        $handlerName = str_replace(
            search: $reflection->getShortName(),
            replace: $handlerName,
            subject: $reflection->getName()
        );

        $handler = App::make(abstract: $handlerName);

        return $handler($query);
    }
}
