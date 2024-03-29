<?php

declare(strict_types=1);

namespace Karting\Track\Application;

use Karting\Pricing\Domain\PriceSet;
use Karting\Shared\Formatter\MoneyFormatter;
use Karting\Track\Track;

class PriceSetListener
{
    public function __construct(private MoneyFormatter $moneyFormatter)
    {
    }

    public function handle(PriceSet $priceSet): void
    {
        $uuid = $priceSet->itemId()->toString();
        $track = Track::where('uuid', $uuid)->first();

        if ($track) {
            $track->price = $this->moneyFormatter->format($priceSet->money());
            $track->save();
        }
    }
}
