<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;

class InDate implements Every
{
    private CarbonInterface $date;

    public function __construct(CarbonInterface $date)
    {
        $this->date = $date;
    }

    public function meet(CarbonPeriod $period): bool
    {
        return $period->getStartDate()->equalTo($this->date);
    }
}
