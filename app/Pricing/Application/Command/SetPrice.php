<?php

declare(strict_types=1);

namespace Karting\Pricing\Application\Command;

use Karting\Pricing\Domain\Price;
use Karting\Shared\Common\Command;
use Karting\Shared\Common\UUID;
use Money\Money;

class SetPrice implements Command
{
    public function __construct(
        private UUID $id,
        private Price $price
    ) {
    }

    public static function of(UUID $id, Money $money): SetPrice
    {
        return new SetPrice($id, new Price($money));
    }

    public function id(): UUID
    {
        return $this->id;
    }

    public function price(): Price
    {
        return $this->price;
    }
}
