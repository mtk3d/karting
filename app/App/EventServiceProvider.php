<?php

declare(strict_types=1);


namespace App\App;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        \App\GoCart\GoCartCreated::class => [
            \App\Availability\Infrastructure\Listener\GoCartCreatedListener::class
        ],
        \App\Availability\Domain\ResourceReserved::class => [
            \App\GoCart\ResourceReservedListener::class
        ],
        \App\Availability\Domain\ResourceWithdrawn::class => [
            \App\GoCart\ResourceWithdrawnListener::class
        ],
        \App\Availability\Domain\ResourceTurnedOn::class => [
            \App\GoCart\ResourceTurnedOnListener::class
        ]
    ];
}
