<?php

declare(strict_types=1);

namespace Karting\Pricing\Infrastructure\Repository\Eloquent;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Karting\Pricing\Domain\Price;

class PriceCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return Price::fromArray(json_decode($attributes['price'], true));
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return ['price' => json_encode($value->toArray())];
    }
}
