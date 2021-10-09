<?php

declare(strict_types=1);

namespace App\ReadModel\Track;

use Karting\Availability\Domain\SlotsUpdated;

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
