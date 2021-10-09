<?php

declare(strict_types=1);

namespace Karting\Shared;

use Carbon\CarbonPeriod;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class CarbonPeriodCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return new CarbonPeriod($attributes['from'], $attributes['to']);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return [
            'from' => $value->getStartDate()->toDateTimeString(),
            'to' => $value->getEndDate()->toDateTimeString(),
        ];
    }
}
