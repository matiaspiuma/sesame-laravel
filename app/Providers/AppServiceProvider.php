<?php

namespace App\Providers;

use Api\V1\EmployeeContext\Employee\Domain\EmployeeRepository;
use Api\V1\EmployeeContext\Employee\Infrastructure\Persistence\DBEmployeeRepository;
use Api\V1\EmployeeContext\WorkEntry\Domain\WorkEntryRepository;
use Api\V1\EmployeeContext\WorkEntry\Infrastructure\Persistence\DBWorkEntryRepository;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Api\V1\SharedContext\Application\RequestInterface;
use Api\V1\SharedContext\Infrastructure\CQRS\Command\LaravelCommandBus;
use Api\V1\SharedContext\Infrastructure\CQRS\Query\LaravelQueryBus;
use Api\V1\SharedContext\Infrastructure\Request\LaravelRequest;
use Api\V1\SharedContext\Infrastructure\Utils\CollectionInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CommandBusInterface::class, LaravelCommandBus::class);

        $this->app->bind(QueryBusInterface::class, LaravelQueryBus::class);

        $this->app->bind(RequestInterface::class, LaravelRequest::class);

        $this->app->bind(EmployeeRepository::class, DBEmployeeRepository::class);

        $this->app->bind(WorkEntryRepository::class, DBWorkEntryRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
