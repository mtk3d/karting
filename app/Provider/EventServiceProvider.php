<?php

declare(strict_types=1);


namespace App\Provider;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listener\EventLogListener;

class EventServiceProvider extends ServiceProvider
{
    /** @var array */
    protected $listen = [
        'Karting\*' => [
            EventLogListener::class
        ],
        \Karting\Shared\ResourceCreated::class => [
        ],
        \Karting\Availability\Domain\ResourceReserved::class => [
            \App\ReadModel\ResourceReservation\ResourceReservedListener::class,
        ],
        \Karting\Availability\Domain\StateChanged::class => [
            \Karting\Kart\Application\StateChangedListener::class,
            \Karting\Track\Application\StateChangedListener::class,
        ],
        \Karting\Availability\Domain\SlotsUpdated::class => [
            \Karting\Track\Application\SlotsUpdatedListener::class,
        ],
        \Karting\Reservation\Domain\ReservationCreated::class => [
            \App\ReadModel\Reservation\ReservationCreatedListener::class,
            \Karting\Pricing\Infrastructure\Listener\ReservationCreatedListener::class,
        ],
        \Karting\Reservation\Domain\ReservationStatusChanged::class => [
            \App\ReadModel\Reservation\ReservationStatusListener::class,
        ],
        \Karting\Pricing\Domain\PriceSet::class => [
            \Karting\Kart\Application\PriceSetListener::class,
            \Karting\Track\Application\PriceSetListener::class,
        ],
        \Karting\Pricing\Domain\PriceCalculated::class => [
            \App\ReadModel\Reservation\PriceCalculatedListener::class,
        ],
    ];

    protected $subscribe = [
        \Karting\Reservation\Application\ReservationManager::class
    ];
}
