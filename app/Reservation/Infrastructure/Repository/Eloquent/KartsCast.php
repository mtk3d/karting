<?php

declare(strict_types=1);

namespace Karting\Reservation\Infrastructure\Repository\Eloquent;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Karting\Reservation\Domain\Kart;

class KartsCast implements CastsAttributes
{
    /**
     * @param  Model  $model
     * @param  string $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return Collection
     */
    public function get($model, $key, $value, $attributes)
    {
        $kartsData = new Collection($attributes['karts']);
        return $kartsData->map(fn (string $kartData): Kart => Kart::fromArray(json_decode($kartData, true)));
    }

    /**
     * @param  Model $model
     * @param  string $key
     * @param  Collection<int, Kart> $value
     * @param  array $attributes
     * @return array
     */
    public function set($model, $key, $value, $attributes)
    {
        if (! $value instanceof Collection) {
            throw new InvalidArgumentException('The given value is not an Collection instance.');
        }

        $value->map(fn (Kart $kart): array => $kart->jsonSerialize());

        return ['karts' => json_encode($value)];
    }
}
