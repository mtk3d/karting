<?php

declare(strict_types=1);

namespace App\Availability\Infrastructure;

use App\Availability\Application\Command\CreateResource;
use App\Availability\Application\Command\ReserveResource;
use App\Availability\Application\Command\TurnOnResource;
use App\Availability\Application\Command\WithdrawResource;
use App\Availability\Application\CreateResourceHandler;
use App\Availability\Application\ReserveResourceHandler;
use App\Availability\Application\TurnOnResourceHandler;
use App\Availability\Application\WithdrawResourceHandler;
use App\Availability\Domain\ResourceRepository;
use App\Availability\Infrastructure\Repository\EloquentResourceRepository;
use App\Shared\Common\CommandBus;
use App\Shared\Common\IlluminateCommandBus;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;

class AvailabilityServiceProvider extends ServiceProvider
{
    /** @var array */
    public $bindings = [
        ResourceRepository::class => EloquentResourceRepository::class,
    ];

    public function register()
    {
        /** @var CommandBus $bus */
        $bus = $this->app->make(CommandBus::class);
        $bus->map([
            ReserveResource::class => ReserveResourceHandler::class,
            TurnOnResource::class => TurnOnResourceHandler::class,
            WithdrawResource::class => WithdrawResourceHandler::class,
            CreateResource::class => CreateResourceHandler::class,
        ]);
    }
}
