<?php

declare(strict_types=1);

namespace Karting\Availability\Infrastructure\Repository\Eloquent;

use Carbon\CarbonPeriod;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Karting\Availability\Domain\Schedule\Recurrence;
use Karting\Availability\Domain\Schedule\RecurrenceRule;
use Karting\Availability\Domain\Schedule\RecurrenceType;

class RecurrenceCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        $recurrenceType = RecurrenceType::from($attributes['recurrence_type']);

        return new Recurrence(
            RecurrenceRule::getRule($recurrenceType, $attributes['recurrence_rule']),
            new CarbonPeriod($attributes['recurrence_start'], $attributes['recurrence_end'])
        );
    }

    public function set($model, string $key, $value, array $attributes)
    {
        /** @var Recurrence $recurrence */
        $recurrence = $value;

        return $recurrence->toArray();
    }
}
