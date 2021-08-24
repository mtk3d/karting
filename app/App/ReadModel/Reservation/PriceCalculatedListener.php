<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\Reservation;

use Karting\App\Formatter\MoneyFormatter;
use Karting\Pricing\Domain\PriceCalculated;

class PriceCalculatedListener
{
    public function __construct(private MoneyFormatter $moneyFormatter)
    {
    }

    public function handle(PriceCalculated $priceCalculated): void
    {
        $reservation = Reservation::where('uuid', $priceCalculated->itemId()->toString())->first();

        if ($reservation) {
            $reservation->price = $this->moneyFormatter->format($priceCalculated->money());
            $reservation->save();
        }
    }
}
