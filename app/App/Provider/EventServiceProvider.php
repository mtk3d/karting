<?php

declare(strict_types=1);


namespace Karting\App\Provider;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Karting\App\Listener\EventLogListener;

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
        \Karting\Availability\Domain\SlotsUpdated::class => [
            \Karting\App\ReadModel\Track\SlotsUpdatedListener::class,
        ],
        \Karting\Reservation\Domain\ReservationCreated::class => [
            \Karting\App\ReadModel\Reservation\ReservationCreatedListener::class,
            \Karting\Pricing\Infrastructure\Listener\ReservationCreatedListener::class,
        ],
        \Karting\Reservation\Domain\ReservationStatusChanged::class => [
            \Karting\App\ReadModel\Reservation\ReservationStatusListener::class,
        ],
        \Karting\Pricing\Domain\PriceSet::class => [
            \Karting\App\ReadModel\Kart\PriceSetListener::class,
            \Karting\App\ReadModel\Track\PriceSetListener::class,
        ],
        \Karting\Pricing\Domain\PriceCalculated::class => [
            \Karting\App\ReadModel\Reservation\PriceCalculatedListener::class,
        ],
    ];

    protected $subscribe = [
        \Karting\Reservation\Application\ReservationManager::class
    ];
}
