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
        // resolve handler
        $reflection = new ReflectionClass($command);
        $handlerName = str_replace("Command", "Handler", $reflection->getShortName());
        $handlerName = str_replace($reflection->getShortName(), $handlerName, $reflection->getName());
        $handler = App::make($handlerName);
        $handler($command);
    }
}
