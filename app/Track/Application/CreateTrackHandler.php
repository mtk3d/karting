<?php

declare(strict_types=1);

namespace Karting\Track\Application;

use Karting\Shared\Common\DomainEventBus;
use Karting\Shared\ResourceCreated;
use Karting\Shared\ResourceId;
use Karting\Track\Application\Command\CreateTrack;
use Karting\Track\Track;
use Karting\Track\TrackCatalog;
use Karting\Track\TrackCreated;

class CreateTrackHandler
{
    private TrackCatalog $catalog;
    private DomainEventBus $bus;

    public function __construct(TrackCatalog $catalog, DomainEventBus $bus)
    {
        $this->catalog = $catalog;
        $this->bus = $bus;
    }

    public function handle(CreateTrack $createTrack): void
    {
        $track = new Track([
            'uuid' => $createTrack->id(),
            'name' => $createTrack->name(),
            'description' => $createTrack->description(),
            'slots' => $createTrack->slots()
        ]);

        $this->catalog->add($track);

        $resourceCreated = ResourceCreated::newOne(ResourceId::of($createTrack->id()->toString()), $createTrack->slots());
        $trackCreated = TrackCreated::newOne($createTrack->id(), $createTrack->name(), $createTrack->description(), $createTrack->slots());

        $this->bus->dispatch($trackCreated);
        $this->bus->dispatch($resourceCreated);
    }
}
