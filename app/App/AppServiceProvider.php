<?php

declare(strict_types=1);


namespace App\App;

use App\Shared\Common\CommandBus;
use App\Shared\Common\DomainEventDispatcher;
use App\Shared\Common\IlluminateCommandBus;
use App\Shared\Common\IlluminateDomainEventDispatcher;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /** @var array */
    public $bindings = [
        DomainEventDispatcher::class => IlluminateDomainEventDispatcher::class,
    ];

    public function register()
    {
        $this->app->singleton(CommandBus::class, IlluminateCommandBus::class);
    }
}
