<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\CarbonPeriod;

interface Every
{
    public function meet(CarbonPeriod $period): bool;
}
