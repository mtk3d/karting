<?php

declare(strict_types=1);


namespace Karting\App\Provider;

use Karting\Shared\Common\CommandBus;
use Karting\Shared\Common\DomainEventBus;
use Karting\Shared\Common\IlluminateCommandBus;
use Illuminate\Support\ServiceProvider;
use Karting\Shared\Common\IlluminateDomainEventBus;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CommandBus::class, IlluminateCommandBus::class);
        $this->app->singleton(DomainEventBus::class, IlluminateDomainEventBus::class);
    }
}
