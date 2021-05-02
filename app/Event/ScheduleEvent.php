<?php


namespace App\Event;


use App\Shared\Common\Command;
use DateTimeImmutable;
use Exception;
use Illuminate\Support\Collection;

class ScheduleEvent implements Command
{
    private DateTimeImmutable $startDate;
    private DateTimeImmutable $endDate;
    /**
     * @var Collection<int, Day>
     */
    private Collection $days;

    /**
     * ScheduleEvent constructor.
     * @param DateTimeImmutable $startDate
     * @param DateTimeImmutable $endDate
     * @param Collection<int, Day> $days
     */
    private function __construct(DateTimeImmutable $startDate, DateTimeImmutable $endDate, Collection $days)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->days = $days;
    }

    /**
     * @param string $rawStartDate
     * @param string $rawEndDate
     * @param array<int, string> $rawDays
     * @return ScheduleEvent
     * @throws Exception
     */
    public static function of(string $rawStartDate, string $rawEndDate, array $rawDays): ScheduleEvent
    {
        $startDate = new DateTimeImmutable($rawStartDate);
        $endDate = new DateTimeImmutable($rawEndDate);
        $days = (new Collection($rawDays))->map(fn (string $day): Day => new Day($day));
        return new ScheduleEvent($startDate, $endDate, $days);
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): DateTimeImmutable
    {
        return $this->endDate;
    }

    /**
     * @return Collection<int, Day>
     */
    public function getDays(): Collection
    {
        return $this->days;
    }
}
