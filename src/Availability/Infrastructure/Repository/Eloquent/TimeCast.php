<?php

declare(strict_types=1);

namespace Karting\Availability\Infrastructure\Repository\Eloquent;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Karting\Availability\Domain\Schedule\Time;

class TimeCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        $time = json_decode($attributes[$key]);
        return new Time($time['hours'], $time['minutes'], $time['seconds']);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        /** @var Time $time */
        $time = $value;

        return [
            $key => json_encode($time),
        ];
    }
}
