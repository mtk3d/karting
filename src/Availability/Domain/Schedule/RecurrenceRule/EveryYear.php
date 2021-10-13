<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule\RecurrenceRule;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;
use Karting\Availability\Domain\Schedule\RecurrenceRule;

class EveryYear extends RecurrenceRule
{
    private CarbonInterface $date;

    public function __construct(CarbonInterface $date)
    {
        $this->date = $date;
    }

    public static function of(string $date): EveryYear
    {
        return new EveryYear(
            new Carbon($date)
        );
    }

    public function meet(CarbonPeriod $period): bool
    {
        $startDate = $period->getStartDate();
        return $startDate->isoFormat('D') === $this->date->isoFormat('D') &&
            $startDate->isoFormat('M') === $this->date->isoFormat('M');
    }

    public function toArray(): array
    {
        return [
            'date' => $this->date->toDateTimeString(),
        ];
    }
}
