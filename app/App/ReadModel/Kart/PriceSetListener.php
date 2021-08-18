<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\Kart;

use Karting\App\Formatter\MoneyFormatter;
use Karting\Pricing\Domain\PriceSet;

class PriceSetListener
{
    public function __construct(private MoneyFormatter $moneyFormatter)
    {
    }

    public function handle(PriceSet $priceSet): void
    {
        $uuid = $priceSet->itemId()->toString();
        $kart = Kart::where('uuid', $uuid)->first();

        if ($kart) {
            $kart->price = $this->moneyFormatter->format($priceSet->money());
            $kart->save();
        }
    }
}
