<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\CarbonPeriod;

class EveryWeek implements RecurrenceRule
{
    private WeekDay $weekDay;

    public function __construct(WeekDay $weekDay)
    {
        $this->weekDay = $weekDay;
    }

    public function meet(CarbonPeriod $period): bool
    {
        return $this->weekDay->getValue() === (int)$period->getStartDate()->isoFormat('d');
    }
}
