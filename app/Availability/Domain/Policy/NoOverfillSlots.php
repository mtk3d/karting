<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Policy;

use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Karting\Availability\Domain\Policy;
use Karting\Availability\Domain\Slots;

class NoOverfillSlots implements Policy
{
    public function isSatisfiedBy(CarbonPeriod $period, Collection $reservedPeriods, Slots $slots): bool
    {
        $taken = $reservedPeriods
            ->filter(fn (CarbonPeriod $p): bool => $p->overlaps($period));

        if (!$taken->isEmpty() && !$taken->first()->equalTo($period)) {
            return false;
        }

        return $slots->hasMoreThan($taken->count());
    }
}
