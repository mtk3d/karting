<?php

declare(strict_types=1);

namespace Karting\Reservation\Infrastructure\Repository\Eloquent;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Karting\Reservation\Domain\Status;
use Karting\Reservation\Domain\Track;

class StatusCast implements CastsAttributes
{
    /**
     * @param  Model  $model
     * @param  string $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return Status
     */
    public function get($model, $key, $value, $attributes)
    {
        return Status::from($attributes['status']);
    }

    /**
     * @param  Model $model
     * @param  string $key
     * @param  mixed $value
     * @param  array $attributes
     * @return array
     */
    public function set($model, $key, $value, $attributes)
    {
        if (! $value instanceof Status) {
            throw new InvalidArgumentException('The given value is not an Status instance.');
        }

        return ['status' => $value->getValue()];
    }
}
