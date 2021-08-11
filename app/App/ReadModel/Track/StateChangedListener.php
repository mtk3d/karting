<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\Track;

use Karting\Availability\Domain\StateChanged;

class StateChangedListener
{
    public function handle(StateChanged $stateChanged): void
    {
        $uuid = $stateChanged->resourceId()->id()->toString();
        $track = Track::where('uuid', $uuid)->first();
        if ($track) {
            $track->enabled = $stateChanged->enabled();
            $track->save();
        }
    }
}
