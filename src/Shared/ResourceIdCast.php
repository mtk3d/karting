<?php

declare(strict_types=1);

namespace Karting\Shared;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ResourceIdCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return ResourceId::of($attributes[$key]);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return [
            $key => $value->id()->toString()
        ];
    }
}
