<?php

declare(strict_types=1);

namespace Api\V1\SharedContext\Infrastructure\CQRS\Command;

use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Api\V1\SharedContext\Application\CQRS\Command\CommandInterface;
use Illuminate\Support\Facades\App;
use ReflectionClass;

final class LaravelCommandBus implements CommandBusInterface
{
    public function execute(CommandInterface $command): void
    {
        $reflection = new ReflectionClass(
            objectOrClass: $command
        );

        $handlerName = str_replace(
            search: "Command",
            replace: "CommandHandler",
            subject: $reflection->getShortName()
        );

        $handlerName = str_replace(
            search: $reflection->getShortName(),
            replace: $handlerName,
            subject: $reflection->getName()
        );

        $handler = App::make(abstract: $handlerName);
        
        $handler($command);
    }
}
