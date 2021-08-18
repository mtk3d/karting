<?php

declare(strict_types=1);

namespace Karting\Shared;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ReservationIdRelationCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return ReservationId::of($attributes['uuid']);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return [
            'uuid' => $value->id()->toString()
        ];
    }
}
