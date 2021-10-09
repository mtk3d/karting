<?php

declare(strict_types=1);

namespace App\Provider;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Karting\Availability\Application\Command\CreateResource;
use Karting\Availability\Application\Command\ReserveResource;
use Karting\Availability\Application\Command\ReserveResources;
use Karting\Availability\Application\Command\SetState;
use Karting\Availability\Application\CreateResourceHandler;
use Karting\Availability\Application\ReserveResourceHandler;
use Karting\Availability\Application\ReserveResourcesHandler;
use Karting\Availability\Application\SetStateHandler;
use Karting\Kart\Application\Command\CreateKart;
use Karting\Kart\Application\CreateKartHandler;
use Karting\Pricing\Application\Command\SetPrice;
use Karting\Pricing\Application\SetPriceHandler;
use Karting\Reservation\Application\CancelReservationHandler;
use Karting\Reservation\Application\Command\CancelReservation;
use Karting\Reservation\Application\Command\ConfirmReservation;
use Karting\Reservation\Application\Command\CreateReservation;
use Karting\Reservation\Application\ConfirmReservationHandler;
use Karting\Reservation\Application\CreateReservationHandler;
use Karting\Shared\Common\CommandBus;
use Karting\Track\Application\Command\CreateTrack;
use Karting\Track\Application\CreateTrackHandler;

class CommandServiceProvider extends ServiceProvider
{
    public function register()
    {
        /** @var CommandBus $bus */
        $bus = $this->app->make(CommandBus::class);
        $bus->map([
            ReserveResource::class => ReserveResourceHandler::class,
            ReserveResources::class => ReserveResourcesHandler::class,
            CreateResource::class => CreateResourceHandler::class,
            CreateTrack::class => CreateTrackHandler::class,
            CreateKart::class => CreateKartHandler::class,
            SetState::class => SetStateHandler::class,
            CreateReservation::class => CreateReservationHandler::class,
            ConfirmReservation::class => ConfirmReservationHandler::class,
            SetPrice::class => SetPriceHandler::class,
            CancelReservation::class => CancelReservationHandler::class,
        ]);
    }
}
