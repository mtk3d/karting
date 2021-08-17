<?php

declare(strict_types=1);

namespace Karting\Reservation\Infrastructure\Repository\Eloquent;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Karting\Reservation\Domain\Track;

class TrackCast implements CastsAttributes
{
    /**
     * @param  Model  $model
     * @param  string $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return Track
     */
    public function get($model, $key, $value, $attributes)
    {
        return Track::fromArray(json_decode($attributes['track'], true));
    }

    /**
     * @param  Model $model
     * @param  string $key
     * @param  Track $value
     * @param  array $attributes
     * @return array
     */
    public function set($model, $key, $value, $attributes)
    {
        if (! $value instanceof Track) {
            throw new InvalidArgumentException('The given value is not an Track instance.');
        }

        return ['track' => json_encode($value)];
    }
}
