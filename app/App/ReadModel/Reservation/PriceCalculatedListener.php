<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\Reservation;

use Karting\Pricing\Domain\PriceCalculated;

class PriceCalculatedListener
{
    public function handle(PriceCalculated $priceCalculated): void
    {
        $reservation = Reservation::where('uuid', $priceCalculated->itemId()->toString())->first();

        if ($reservation) {
            $reservation->price = $priceCalculated->price();
            $reservation->save();
        }
    }
}
