<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\Employee\Application\DeleteEmployee;

use Api\V1\SharedContext\Application\CQRS\Command\CommandHandlerInterface;
use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;

final class DeleteEmployeeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EmployeeDeletor $delector
    ) {
    }

    public function __invoke(DeleteEmployeeCommand $command): void
    {
        $this->delector->__invoke(
            employeeId: new EmployeeId($command->id()),
        );
    }
}
