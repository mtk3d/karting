<?php

declare(strict_types=1);

namespace Karting\Track\Application;

use Karting\Availability\Domain\StateChanged;
use Karting\Track\Track;

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
