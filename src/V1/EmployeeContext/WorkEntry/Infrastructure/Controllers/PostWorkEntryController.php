<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Infrastructure\Controllers;

use Api\V1\EmployeeContext\Employee\Infrastructure\Responses\WorkEntryResponse;
use Api\V1\EmployeeContext\WorkEntry\Application\CreateWorkEntry\CreateWorkEntryCommand;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use App\Http\Requests\Api\V1\EmployeeContext\WorkEntry\Infrastructure\Requests\CreateWorkEntryRequest;
use Symfony\Component\HttpFoundation\Request;

final class PostWorkEntryController
{
    public function __construct(
        private CommandBusInterface $commandBus
    )
    {
    }

    public function __invoke(
        Request $request,
        string  $employeeId
    ): WorkEntry
    {
        $workEntryId = WorkEntryId::make();

        return $this->commandBus->execute(
            new CreateWorkEntryCommand(
                $workEntryId->value(),
                $employeeId,
                $request->get('startDate'),
                $request->get('endDate'),
            )
        );
    }
}
