<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule\RecurrenceRule;

use Carbon\CarbonPeriod;
use Karting\Availability\Domain\Schedule\RecurrenceRule;

class EveryMonth extends RecurrenceRule
{
    private WeekDay $weekDay;
    private int $weekOfMonth;

    public function __construct(WeekDay $weekDay, int $weekOfMonth)
    {
        $this->weekDay = $weekDay;
        $this->weekOfMonth = $weekOfMonth;
    }

    public static function of(string $weekDay, int $weekOfMonth): EveryMonth
    {
        return new EveryMonth(
            WeekDay::from($weekDay),
            $weekOfMonth
        );
    }

    public function meet(CarbonPeriod $period): bool
    {
        $startDate = $period->getStartDate();
        /** @psalm-suppress NoInterfaceProperties **/
        $weekOfMonth = $startDate->weekOfMonth;
        return $this->weekOfMonth === $weekOfMonth &&
            $this->weekDay->getValue() === (int)$startDate->isoFormat('d');
    }

    public function toArray(): array
    {
        return [
            'week_day' => $this->weekDay->getValue(),
            'week_of_month' => $this->weekOfMonth
        ];
    }
}
