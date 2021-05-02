<?php


namespace App\Event;


use App\Shared\Common\Command;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;

class EventsBetween implements Command
{
    private CarbonPeriod $period;

    public function __construct(CarbonPeriod $period)
    {
        $this->period = $period;
    }

    public static function of(string $rawFrom, string $rawTo): EventsBetween
    {
        return new EventsBetween(new CarbonPeriod($rawFrom, $rawTo));
    }

    public function getPeriod(): CarbonPeriod
    {
        return $this->period;
    }

    /**
     * @return array<int, CarbonInterface>
     */
    public function getBetweenDates(): array
    {
        return [
            $this->period->getStartDate(),
            $this->period->getEndDate()
        ];
    }
}
