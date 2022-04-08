<?php

declare(strict_types=1);

namespace Api\V1\SharedContext\Infrastructure\ORM;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;

abstract class DoctrineRepository extends ServiceEntityRepository
{
    protected ObjectRepository $objectRepository;

    public function __construct(
        private ManagerRegistry $managerRegistry,
        protected Connection $connection
    ) {
        parent::__construct($managerRegistry, $this->entityClass());
    }

    abstract protected static function entityClass(): string;
}
