<?php

declare(strict_types=1);

namespace Karting\Pricing\Application\Command;

use Karting\Shared\Common\Command;
use Karting\Shared\Common\UUID;

class SetPrice implements Command
{
    private UUID $id;
    private float $price;

    public function __construct(UUID $id, float $price)
    {
        $this->id = $id;
        $this->price = $price;
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
