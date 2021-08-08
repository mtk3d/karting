<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\Kart;

use Karting\Availability\Domain\StateChanged;

class StateChangedListener
{
    public function handle(StateChanged $stateChanged): void
    {
        $uuid = $stateChanged->resourceId()->id()->toString();
        $kart = Kart::where('uuid', $uuid)->first();
        if ($kart) {
            $kart->enabled = $stateChanged->enabled();
            $kart->save();
        }
    }
}
