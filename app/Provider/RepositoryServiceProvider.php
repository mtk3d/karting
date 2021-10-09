<?php

declare(strict_types=1);

namespace App\Provider;

use Illuminate\Support\ServiceProvider;
use Karting\Availability\Domain\ResourceRepository;
use Karting\Availability\Infrastructure\Repository\EloquentResourceRepository;
use Karting\Pricing\Domain\PricedItemRepository;
use Karting\Pricing\Infrastructure\Repository\EloquentPricedItemRepository;
use Karting\Reservation\Domain\ReservationRepository;
use Karting\Reservation\Infrastructure\Repository\EloquentReservationRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /** @var array */
    public $bindings = [
        ResourceRepository::class => EloquentResourceRepository::class,
        ReservationRepository::class => EloquentReservationRepository::class,
        PricedItemRepository::class => EloquentPricedItemRepository::class,
    ];
}
