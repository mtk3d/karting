<?php

declare(strict_types=1);


namespace App\Availability\Domain;

use InvalidArgumentException;

class Slots
{
    /** @var int */
    private int $slots;

    public function __construct(int $slots)
    {
        if ($slots < 0) {
            throw new InvalidArgumentException('Slots cannot be lower than 0');
        }

        $this->slots = $slots;
    }

    public static function of(int $int): Slots
    {
        return new Slots($int);
    }

    public function hasMoreThan(int $takenSlots): bool
    {
        return $this->slots > $takenSlots;
    }

    public function slots(): int
    {
        return $this->slots;
    }
}
