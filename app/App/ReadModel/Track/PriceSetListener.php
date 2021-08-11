<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\Track;

use Karting\Pricing\Domain\PriceSet;

class PriceSetListener
{
    public function handle(PriceSet $priceSet): void
    {
        $uuid = $priceSet->itemId()->toString();
        $track = Track::where('uuid', $uuid)->first();

        if ($track) {
            $track->price = $priceSet->price();
            $track->save();
        }
    }
}
