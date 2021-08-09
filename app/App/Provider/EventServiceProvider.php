<?php

declare(strict_types=1);


namespace Karting\App\Provider;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Karting\App\EventLogListener;

class EventServiceProvider extends ServiceProvider
{
    /** @var array */
    protected $listen = [
        \Karting\Shared\ResourceCreated::class => [
            \Karting\Availability\Infrastructure\Listener\ResourceCreatedListener::class,
        ],
        \Karting\Availability\Domain\ResourceReserved::class => [
            \Karting\App\ReadModel\ResourceReservation\ResourceReservedListener::class,
        ],
        \Karting\Track\TrackCreated::class => [
            \Karting\App\ReadModel\Track\TrackCreatedListener::class,
        ],
        \Karting\Kart\KartCreated::class => [
            \Karting\App\ReadModel\Kart\KartCreatedListener::class,
        ],
        \Karting\Availability\Domain\StateChanged::class => [
            \Karting\App\ReadModel\Kart\StateChangedListener::class,
            \Karting\App\ReadModel\Track\StateChangedListener::class,
        ],
        \Karting\Reservation\Domain\ReservationCreated::class => [
            \Karting\App\ReadModel\Reservation\ReservationCreatedListener::class,
        ],
        \Karting\Reservation\Domain\ReservationConfirmed::class => [
            \Karting\App\ReadModel\Reservation\ReservationConfirmedListener::class,
        ],
        'Karting\*' => [
            EventLogListener::class
        ]
    ];

    protected $subscribe = [
        \Karting\Reservation\Application\ReservationManager::class
    ];
}
