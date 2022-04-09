<?php

declare(strict_types=1);

namespace Api\V1\EmployeeContext\WorkEntry\Application\FindWorkEntry;

use Api\V1\EmployeeContext\WorkEntry\Domain\ValueObjects\WorkEntryId;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntry;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntryRepository;

final class WorkEntryFinder
{
    public function __construct(
        private WorkEntryRepository $repository
    ) {
    }

    public function __invoke(WorkEntryId $workEntryId): WorkEntry
    {
        return $this->repository->findById($workEntryId);
    }
}
