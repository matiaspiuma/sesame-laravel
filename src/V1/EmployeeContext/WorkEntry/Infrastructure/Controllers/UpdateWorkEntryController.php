<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Employee\Infrastructure\Responses\WorkEntryResponse;
use Api\V1\EmployeeContext\WorkEntry\Application\UpdateWorkEntry\UpdateWorkEntryCommand;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\Request;

final class UpdateWorkEntryController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private QueryBusInterface   $queryBus
    )
    {
    }

    public function __invoke(
        Request $request,
        string  $employeeId,
        string  $workEntryId
    ): WorkEntry
    {
        return $this->commandBus->execute(
            new UpdateWorkEntryCommand(
                $workEntryId,
                $employeeId,
                $request->get('startDate'),
                $request->get('endDate')
            )
        );
    }
}
