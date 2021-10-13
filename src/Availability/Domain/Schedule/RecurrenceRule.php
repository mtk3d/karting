<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\CarbonPeriod;
use InvalidArgumentException;
use Karting\Availability\Domain\Schedule\RecurrenceRule\EveryMonth;
use Karting\Availability\Domain\Schedule\RecurrenceRule\EveryWeek;
use Karting\Availability\Domain\Schedule\RecurrenceRule\EveryYear;
use Karting\Availability\Domain\Schedule\RecurrenceRule\InDay;

abstract class RecurrenceRule
{
    abstract public function meet(CarbonPeriod $period): bool;

    abstract public function toArray(): array;

    public static function getRule(RecurrenceType $type, array $payload): RecurrenceRule
    {
        return match ($type) {
            RecurrenceType::EVERY_MONTH() => EveryMonth::of($payload['week_day'], $payload['week_of_month']),
            RecurrenceType::EVERY_WEEK() => EveryWeek::of($payload['week_day']),
            RecurrenceType::EVERY_YEAR() => EveryYear::of($payload['date']),
            RecurrenceType::IN_DAY() => InDay::of($payload['date']),
            default => throw new InvalidArgumentException('ResourceRule not found'),
        };
    }
}
