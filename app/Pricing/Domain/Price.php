<?php

declare(strict_types=1);

namespace Karting\Pricing\Domain;

use JsonSerializable;

class Price implements JsonSerializable
{
    public function __construct(private float $value)
    {
    }

    public static function fromArray(array $payload): Price
    {
        return new Price($payload['value']);
    }

    public function value(): float
    {
        return $this->value;
    }

    public function jsonSerialize(): array
    {
        return [
            'value' => $this->value
        ];
    }
}
