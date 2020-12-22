<?php

declare(strict_types=1);


namespace App\App;

use App\Availability\Application\Command\CreateResource;
use App\Availability\Application\Command\ReserveResource;
use App\Availability\Application\Command\TurnOnResource;
use App\Availability\Application\Command\WithdrawResource;
use App\Availability\Application\CreateResourceHandler;
use App\Availability\Application\ReserveResourceHandler;
use App\Availability\Application\TurnOnResourceHandler;
use App\Availability\Application\WithdrawResourceHandler;
use App\Shared\Common\CommandBus;
use App\Shared\Common\DomainEventDispatcher;
use App\Shared\Common\IlluminateCommandBus;
use App\Shared\Common\IlluminateDomainEventDispatcher;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $bindings = [
        DomainEventDispatcher::class => IlluminateDomainEventDispatcher::class,
    ];

    public function register()
    {
        $this->app->singleton(CommandBus::class, IlluminateCommandBus::class);
    }
}
