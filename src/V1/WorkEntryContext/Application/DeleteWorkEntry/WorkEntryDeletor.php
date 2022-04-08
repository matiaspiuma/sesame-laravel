<?php

declare(strict_types=1);

namespace Api\V1\WorkEntryContext\Application\DeleteWorkEntry;

use Api\V1\WorkEntryContext\Domain\ValueObjects\WorkEntryId;
use Api\V1\WorkEntryContext\Domain\WorkEntryRepository;

final class WorkEntryDeletor
{
    public function __construct(
        private WorkEntryRepository $repository
    ) {
    }

    public function __invoke(
        WorkEntryId $workEntryId,
    ): void {
        $workEntry = $this->repository->findById($workEntryId);

        $workEntry->delete();

        $this->repository->delete($workEntry);
    }
}
