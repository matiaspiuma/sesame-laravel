<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\DeleteWorkEntry;

use Api\V1\EmployeeContext\Shared\Domain\Employee\EmployeeId;
use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntryNotExistsException;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntryRepository;

final class WorkEntryDeletor
{
    public function __construct(
        private WorkEntryRepository $repository
    )
    {
    }

    public function __invoke(
        WorkEntryId $workEntryId,
        EmployeeId $employeeId,
    ): void
    {
        $workEntry = $this->repository->findByIdAndEmployeeId($workEntryId, $employeeId);

        if (null == $workEntry) {
            throw new WorkEntryNotExistsException();
        }

        $workEntry->delete();

        $this->repository->delete($workEntry);
    }
}
