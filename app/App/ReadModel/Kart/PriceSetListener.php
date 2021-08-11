<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\Kart;

use Karting\Pricing\Domain\PriceSet;

class PriceSetListener
{
    public function handle(PriceSet $priceSet): void
    {
        $uuid = $priceSet->itemId()->toString();
        $kart = Kart::where('uuid', $uuid)->first();

        if ($kart) {
            $kart->price = $priceSet->price();
            $kart->save();
        }
    }
}
