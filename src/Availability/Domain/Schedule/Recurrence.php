<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\CarbonPeriod;

class Recurrence
{
    private RecurrenceRule $recurrenceRule;
    private CarbonPeriod $range;

    public function __construct(RecurrenceRule $recurrenceRule, CarbonPeriod $range)
    {
        $this->recurrenceRule = $recurrenceRule;
        $this->range = $range;
    }

    public function meet(CarbonPeriod $period): bool
    {
        return $this->range->overlaps($period) && $this->recurrenceRule->meet($period);
    }

    public function toArray(): array
    {
        return [
            'recurrence_rule' => $this->recurrenceRule->toArray(),
            'recurrence_type' => RecurrenceType::fromRule($this->recurrenceRule)->getValue(),
            'recurrence_start' => $this->range->getStartDate()->toDateTimeString(),
            'recurrence_end' => $this->range->getEndDate()->toDateTimeString(),
        ];
    }
}
