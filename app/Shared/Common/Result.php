<?php

declare(strict_types=1);

namespace Karting\Shared\Common;

use Karting\Shared\Common\Result\Failure;
use Karting\Shared\Common\Result\Success;
use Illuminate\Support\Collection;

abstract class Result
{
    protected string $reason;
    /** @var Collection<int, DomainEvent> */
    protected Collection $events;

    /**
     * @param DomainEvent[]|null $events
     * @return Success
     */
    public static function success(?DomainEvent ...$events): Success
    {
        return new Success(collect($events));
    }

    /**
     * @param DomainEvent[]|null $events
     * @return Failure
     */
    public static function failure(string $reason, ?DomainEvent ...$events): Failure
    {
        return new Failure($reason, collect($events));
    }

    public function isFailure(): bool
    {
        return $this instanceof Failure;
    }

    public function isSuccessful(): bool
    {
        return $this instanceof Success;
    }

    public function reason(): string
    {
        if ($this->isFailure()) {
            return $this->reason;
        }

        return 'OK';
    }

    /**
     * @return Collection<int, DomainEvent>
     */
    public function events(): Collection
    {
        return $this->events;
    }
}
