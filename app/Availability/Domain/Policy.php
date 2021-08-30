<?php

declare(strict_types=1);

namespace Karting\Availability\Domain;

use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

interface Policy
{
    /**
     * @param Collection<int, CarbonPeriod> $reservedPeriods
     */
    public function isSatisfiedBy(CarbonPeriod $period, Collection $reservedPeriods, Slots $slots): bool;
}
