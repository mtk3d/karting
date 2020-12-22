<?php

declare(strict_types=1);

namespace App\Availability\Infrastructure\Http;

use App\Availability\Application\Command\ReserveResource;
use App\Shared\Common\CommandBus;
use App\Shared\Http\Controller;

class ReservationController extends Controller
{
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function reserve(string $id, ReservationRequest $request): void
    {
        $command = ReserveResource::fromRaw(
            $id,
            $request->get('from'),
            $request->get('to')
        );

        $this->bus->dispatch($command);
    }
}
