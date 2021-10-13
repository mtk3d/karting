<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;

class InDay implements RecurrenceRule
{
    private CarbonInterface $date;

    public function __construct(CarbonInterface $date)
    {
        $this->date = $date;
    }

    public function meet(CarbonPeriod $period): bool
    {
        // only day month year without hours *
        return $period->getStartDate()->equalTo($this->date);
    }
}
