<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\CarbonPeriod;

class EveryMonth implements Every
{
    private WeekDay $weekDay;
    private int $which;

    public function __construct(WeekDay $weekDay, int $which)
    {
        $this->weekDay = $weekDay;
        $this->which = $which;
    }

    public function meet(CarbonPeriod $period): bool
    {
        $startDate = $period->getStartDate();
        return $this->which === $startDate->weekOfMonth && $this->weekDay->getValue() === $startDate->dayOfWeek;
    }
}
