<?php

declare(strict_types=1);

namespace Karting\Track;

class TrackCatalog
{
    public function add(Track $track): void
    {
        $track->save();
    }
}
