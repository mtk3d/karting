<?php

declare(strict_types=1);

namespace Karting\Shared\Common;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class UUIDCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return new UUID($attributes['uuid']);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return [
            'uuid' => $value->toString()
        ];
    }
}
