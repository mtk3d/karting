<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule\RecurrenceRule;

use Carbon\CarbonPeriod;
use Karting\Availability\Domain\Schedule\RecurrenceRule;

class EveryWeek extends RecurrenceRule
{
    private WeekDay $weekDay;

    public function __construct(WeekDay $weekDay)
    {
        $this->weekDay = $weekDay;
    }

    public static function of(string $weekDay): EveryWeek
    {
        return new EveryWeek(
            WeekDay::from($weekDay)
        );
    }

    public function meet(CarbonPeriod $period): bool
    {
        return $this->weekDay->getValue() === (int)$period->getStartDate()->isoFormat('d');
    }

    public function toArray(): array
    {
        return [
            'week_day' => $this->weekDay->getValue(),
        ];
    }
}
