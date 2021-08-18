<?php

declare(strict_types=1);

namespace Karting\Pricing\Domain;

use Karting\Shared\Common\DomainEvent;
use Karting\Shared\Common\UUID;
use Money\Money;

class PriceSet implements DomainEvent
{
    public function __construct(
        private UUID $id,
        private UUID $itemId,
        private Money $money
    ) {
    }

    public static function newOne(UUID $id, Money $money): self
    {
        return new self(UUID::random(), $id, $money);
    }

    public function eventId(): UUID
    {
        return $this->id;
    }

    public function itemId(): UUID
    {
        return $this->itemId;
    }

    public function money(): Money
    {
        return $this->money;
    }
}
