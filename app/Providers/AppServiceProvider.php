<?php

namespace App\Providers;

use Api\V1\EmployeeContext\Domain\EmployeeRepository;
use Api\V1\EmployeeContext\Infrastructure\Persistence\EloquentEmployeeRepository;
use Api\V1\SharedContext\Application\CQRS\Command\CommandBusInterface;
use Api\V1\SharedContext\Application\CQRS\Query\QueryBusInterface;
use Api\V1\SharedContext\Application\RequestInterface;
use Api\V1\SharedContext\Infrastructure\CQRS\Command\LaravelCommandBus;
use Api\V1\SharedContext\Infrastructure\CQRS\Query\LaravelQueryBus;
use Api\V1\SharedContext\Infrastructure\Request\LaravelRequest;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            abstract: CommandBusInterface::class,
            concrete: LaravelCommandBus::class
        );

        $this->app->bind(
            abstract: QueryBusInterface::class,
            concrete: LaravelQueryBus::class
        );

        $this->app->bind(
            abstract: RequestInterface::class,
            concrete: LaravelRequest::class
        );

        $this->app->bind(
            abstract: EmployeeRepository::class,
            concrete: EloquentEmployeeRepository::class
        );
    }
    
    public function boot(): void
    {
        //
    }
}
