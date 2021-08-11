<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\Track;

use Karting\Track\TrackCreated;

class TrackCreatedListener
{
    public function handle(TrackCreated $trackCreated): void
    {
        Track::create([
            'uuid' => $trackCreated->id()->toString(),
            'name' => $trackCreated->name(),
            'description' => $trackCreated->description()
        ]);
    }
}
