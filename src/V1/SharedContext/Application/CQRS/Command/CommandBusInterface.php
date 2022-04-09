<?php

declare(strict_types=1);

namespace Api\V1\SharedContext\Application\CQRS\Command;

interface CommandBusInterface
{
    public function execute(CommandInterface $command): mixed;
}
