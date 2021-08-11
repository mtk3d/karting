<?php

declare(strict_types=1);

namespace Karting\Pricing\Application\Command;

use Karting\Shared\Common\Command;
use Karting\Shared\Common\UUID;

class SetPrice implements Command
{
    public function __construct(private UUID $id, private float $price)
    {
    }

    public function id(): UUID
    {
        return $this->id;
    }

    public function price(): float
    {
        return $this->price;
    }
}
