<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\CarbonPeriod;

interface HowOften
{
    public function meet(CarbonPeriod $period): bool;
}
