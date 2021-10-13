<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\CarbonPeriod;

class EveryMonth implements RecurrenceRule
{
    private WeekDay $weekDay;
    private int $weekOfMonth;

    public function __construct(WeekDay $weekDay, int $weekOfMonth)
    {
        $this->weekDay = $weekDay;
        $this->weekOfMonth = $weekOfMonth;
    }

    public function meet(CarbonPeriod $period): bool
    {
        $startDate = $period->getStartDate();
        return $this->weekOfMonth === $startDate->weekOfMonth &&
            $this->weekDay->getValue() === (int)$startDate->isoFormat('d');
    }
}
