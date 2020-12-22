<?php

declare(strict_types=1);

namespace App\Availability\Infrastructure\Http;

use App\Availability\Application\Command\TurnOnResource;
use App\Availability\Application\Command\WithdrawResource;
use App\Shared\Common\CommandBus;
use App\Shared\Http\Controller;
use App\Shared\ResourceId;

class AvailabilityController extends Controller
{
    private CommandBus $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function changeResource(string $id, ChangeResourceRequest $request): void
    {
        $resourceId = ResourceId::of($id);
        if ($request->get('is_available')) {
            $this->bus->dispatch(new TurnOnResource($resourceId));
        } else {
            $this->bus->dispatch(new WithdrawResource($resourceId));
        }
    }
}
