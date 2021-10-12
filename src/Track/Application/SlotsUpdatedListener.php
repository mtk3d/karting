<?php

declare(strict_types=1);

namespace Karting\Track\Application;

use Karting\Availability\Domain\SlotsUpdated;
use Karting\Track\Track;

class SlotsUpdatedListener
{
    public function handle(SlotsUpdated $slotsUpdated): void
    {
        $track = Track::where('uuid', $slotsUpdated->resourceId()->id()->toString())->first();

        if ($track) {
            $track->slots = $slotsUpdated->slots();
            $track->save();
        }
    }
}
