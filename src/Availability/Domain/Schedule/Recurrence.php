<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\CarbonPeriod;

class Periodicity
{
    private Occurrence $occurrence;
    private CarbonPeriod $range;

    public function __construct(Occurrence $occurrence, CarbonPeriod $range)
    {
        $this->occurrence = $occurrence;
        $this->range = $range;
    }

    public function meet(CarbonPeriod $period): bool
    {
        return $this->range->overlaps($period) && $this->occurrence->meet($period);
    }
}
