<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class EveryYear implements RecurrenceRule
{
    private Carbon $date;

    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    public function meet(CarbonPeriod $period): bool
    {
        $startDate = $period->getStartDate();
        return $startDate->isoFormat('D') === $this->date->isoFormat('D') &&
            $startDate->isoFormat('M') === $this->date->isoFormat('M');
    }
}
