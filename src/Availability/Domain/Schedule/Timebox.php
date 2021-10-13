<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\CarbonPeriod;

class Timebox
{
    private Time $startTime;
    private Time $endTime;
    private Periodicity $periodicity;

    public function __construct(Time $startTime, Time $endTime, Periodicity $periodicity)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->periodicity = $periodicity;
    }

    public function meet(CarbonPeriod $period): bool
    {
        return $this->startTime->equalsDate($period->getStartDate()) &&
            $this->endTime->equalsDate($period->getEndDate()) &&
            $this->periodicity->meet($period);
    }
}
