<?php

declare(strict_types=1);

namespace App\Provider;

use Illuminate\Support\ServiceProvider;
use Karting\Reservation\Domain\ReservationFactory;
use Karting\Reservation\Infrastructure\Factory\EloquentReservationFactory;

class FactoryServiceProvider extends ServiceProvider
{
    /** @var array */
    public $bindings = [
        ReservationFactory::class => EloquentReservationFactory::class,
    ];
}
