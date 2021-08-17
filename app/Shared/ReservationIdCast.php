<?php

declare(strict_types=1);

namespace Karting\Shared;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ReservationIdCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return ReservationId::of($attributes['uuid']);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return [
            'reservation_id' => $value->id()->toString()
        ];
    }
}
