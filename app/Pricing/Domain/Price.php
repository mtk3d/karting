<?php

declare(strict_types=1);

namespace Karting\Pricing\Domain;

use JsonSerializable;

class Price implements JsonSerializable
{
    private float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
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
