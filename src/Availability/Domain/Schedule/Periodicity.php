<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\CarbonPeriod;

class Periodicity
{
    private Every $every;
    private CarbonPeriod $range;

    public function __construct(Every $every, CarbonPeriod $range)
    {
        $this->every = $every;
        $this->range = $range;
    }

    public function meet(CarbonPeriod $period): bool
    {
        return $this->range->overlaps($period) && $this->every->meet($period);
    }
}
