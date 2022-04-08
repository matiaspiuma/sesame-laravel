<?php

declare(strict_types=1);

namespace Api\V1\SharedContext\Infrastructure\CQRS\Query;

use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class SymfonyQueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function execute(QueryInterface $query): mixed
    {
        return $this->handle(
            message: $query
        );
    }
}
