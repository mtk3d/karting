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
        \Karting\Track\TrackCreated::class => [
            \App\ReadModel\Track\TrackCreatedListener::class,
        ],
        \Karting\Kart\KartCreated::class => [
            \App\ReadModel\Kart\KartCreatedListener::class,
        ],
        \Karting\Availability\Domain\StateChanged::class => [
            \App\ReadModel\Kart\StateChangedListener::class,
            \App\ReadModel\Track\StateChangedListener::class,
        ],
        \Karting\Availability\Domain\SlotsUpdated::class => [
            \App\ReadModel\Track\SlotsUpdatedListener::class,
        ],
        \Karting\Reservation\Domain\ReservationCreated::class => [
            \App\ReadModel\Reservation\ReservationCreatedListener::class,
            \Karting\Pricing\Infrastructure\Listener\ReservationCreatedListener::class,
        ],
        \Karting\Reservation\Domain\ReservationStatusChanged::class => [
            \App\ReadModel\Reservation\ReservationStatusListener::class,
        ],
        \Karting\Pricing\Domain\PriceSet::class => [
            \App\ReadModel\Kart\PriceSetListener::class,
            \App\ReadModel\Track\PriceSetListener::class,
        ],
        \Karting\Pricing\Domain\PriceCalculated::class => [
            \App\ReadModel\Reservation\PriceCalculatedListener::class,
        ],
    ];

    protected $subscribe = [
        \Karting\Reservation\Application\ReservationManager::class
    ];
}
