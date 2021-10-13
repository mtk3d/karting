<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class EveryYear implements Every
{
    private Carbon $date;

    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    public function meet(CarbonPeriod $period): bool
    {
        $startDate = $period->getStartDate();
        return $startDate->day === $this->date->day &&
            $startDate->month === $this->date->month;
    }
}
