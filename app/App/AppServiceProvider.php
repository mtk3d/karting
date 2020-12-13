<?php

declare(strict_types=1);


namespace App\App;


use App\Shared\Common\DomainEventDispatcher;
use App\Shared\Common\IlluminateDomainEventDispatcher;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $bindings = [
        DomainEventDispatcher::class => IlluminateDomainEventDispatcher::class,
    ];
}
