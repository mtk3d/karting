<?php

declare(strict_types=1);

namespace Karting\Pricing\Domain;

use Money\Currency;
use Money\Money;

class Price
{
    public function __construct(private Money $money)
    {
    }

    public static function fromArray(array $payload): Price
    {
        return new Price(new Money($payload['amount'], new Currency($payload['currency'])));
    }

    public static function of(int $value): Price
    {
        return new Price(new Money($value, new Currency('USD')));
    }

    public function add(Price $price): Price
    {
        return new Price($this->money->add($price->money));
    }

    public function toArray(): array
    {
        return [
            'amount' => (int)$this->money->getAmount(),
            'currency' => $this->money->getCurrency()->getCode()
        ];
    }

    public function money(): Money
    {
        return $this->money;
    }
}
