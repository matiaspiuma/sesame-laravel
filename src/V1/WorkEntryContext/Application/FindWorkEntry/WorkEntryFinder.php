<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Application\FindWorkEntry;

use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryId;
use Api\V1\WorkEntryContext\Domain\WorkEntry;
use Api\V1\WorkEntryContext\Domain\WorkEntryRepository;

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
