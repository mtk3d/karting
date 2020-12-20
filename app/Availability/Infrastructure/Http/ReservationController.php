<?php

declare(strict_types=1);

namespace App\Availability\Infrastructure\Http;


use App\Availability\Application\Command\ReserveResource;
use App\Shared\Http\Controller;
use Joselfonseca\LaravelTactician\CommandBusInterface;

class ReservationController extends Controller
{
    private CommandBusInterface $bus;

    public function __construct(CommandBusInterface $bus)
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
