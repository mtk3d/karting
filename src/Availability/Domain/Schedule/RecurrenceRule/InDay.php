<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule\RecurrenceRule;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;
use Karting\Availability\Domain\Schedule\RecurrenceRule;

class InDay extends RecurrenceRule
{
    private CarbonInterface $date;

    public function __construct(CarbonInterface $date)
    {
        $this->date = $date;
    }

    public static function of(string $date): InDay
    {
        return new InDay(
            new Carbon($date)
        );
    }

    public function meet(CarbonPeriod $period): bool
    {
        $startDate = $period->getStartDate();
        return $startDate->isoFormat('D') === $this->date->isoFormat('D') &&
            $startDate->isoFormat('M') === $this->date->isoFormat('M') &&
            $startDate->isoFormat('Y') === $this->date->isoFormat('Y');
    }

    public function toArray(): array
    {
        return [
            'date' => $this->date->toDateTimeString(),
        ];
    }
}
