<?php

declare(strict_types=1);

namespace Karting\Availability\Infrastructure\Repository\Eloquent;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Karting\Availability\Domain\Slots;

class SlotsCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return Slots::of($attributes['slots']);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return [
            'slots' => $value->quantity()
        ];
    }
}
