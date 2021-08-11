<?php

declare(strict_types=1);

namespace Karting\Pricing\Domain;

use Karting\Shared\Common\DomainEvent;
use Karting\Shared\Common\UUID;

class PriceCalculated implements DomainEvent
{
    public function __construct(private UUID $id, private UUID $itemId, private float $price)
    {
    }

    public static function newOne(UUID $id, float $price): self
    {
        return new self(UUID::random(), $id, $price);
    }

    public function eventId(): UUID
    {
        return $this->id;
    }

    public function itemId(): UUID
    {
        return $this->itemId;
    }

    public function price(): float
    {
        return $this->price;
    }
}
