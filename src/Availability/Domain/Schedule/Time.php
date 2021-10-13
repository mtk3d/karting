<?php

declare(strict_types=1);

namespace Karting\Availability\Domain\Schedule;

use Carbon\CarbonInterface;
use InvalidArgumentException;

class Time
{
    private int $hours;
    private int $minutes;
    private int $seconds;

    public function __construct(int $hours, int $minutes, int $seconds)
    {
        if ($hours > 23 || $minutes > 59 || $seconds > 59 ||
            $hours < 0 || $minutes < 0 || $seconds < 0) {
            throw new InvalidArgumentException("Provided values are not a valid time");
        }

        $this->hours = $hours;
        $this->minutes = $minutes;
        $this->seconds = $seconds;
    }

    public function equals(Time $time): bool
    {
        return $this->hours === $time->hours &&
            $this->minutes === $time->minutes &&
            $this->seconds === $time->seconds;
    }

    public function equalsDate(CarbonInterface $date): bool
    {
        return $this->hours === (int)$date->isoFormat('H') &&
            $this->minutes === (int)$date->isoFormat('m') &&
            $this->seconds === (int)$date->isoFormat('s');
    }

    public function diff(Time $time): Time
    {
        return new Time(
            abs($this->hours - $time->hours),
            abs($this->minutes - $time->minutes),
            abs($this->seconds - $time->seconds)
        );
    }
}
