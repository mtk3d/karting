<?php

declare(strict_types=1);


namespace App\App;


use App\Availability\Application\Command\CreateResource;
use App\Availability\Application\CreateResourceHandler;
use App\Availability\Application\TurnOnResourceHandler;
use App\Availability\Application\WithdrawResourceHandler;
use App\Availability\Application\Command\ReserveResource;
use App\Availability\Application\Command\TurnOnResource;
use App\Availability\Application\Command\WithdrawResource;
use App\Availability\Application\ReserveResourceHandler;
use App\Shared\Common\DomainEventDispatcher;
use App\Shared\Common\IlluminateDomainEventDispatcher;
use Illuminate\Support\ServiceProvider;
use Joselfonseca\LaravelTactician\CommandBusInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $bindings = [
        DomainEventDispatcher::class => IlluminateDomainEventDispatcher::class,
    ];

    protected array $commandBindings = [
        ReserveResource::class => ReserveResourceHandler::class,
        TurnOnResource::class => TurnOnResourceHandler::class,
        WithdrawResource::class => WithdrawResourceHandler::class,
        CreateResource::class => CreateResourceHandler::class,
    ];

    public function register()
    {
        /** @var CommandBusInterface $bus */
        $bus = $this->app->make(CommandBusInterface::class);
        collect($this->commandBindings)->each(function (string $handler, string $command) use ($bus): void{
            $bus->addHandler($command, $handler);
        });
        $this->app->instance(CommandBusInterface::class, $bus);
    }
}
