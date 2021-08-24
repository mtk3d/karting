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
     * @param Collection<int, DomainEvent>|null $events
     * @return Success
     */
    public static function success(Collection $events = null): Success
    {
        if ($events === null) {
            $events = collect();
        }
        return new Success($events);
    }

    /**
     * @param Collection<int, DomainEvent>|null $events
     * @return Failure
     */
    public static function failure(string $reason, Collection $events = null): Failure
    {
        if ($events === null) {
            $events = collect();
        }
        return new Failure($reason, $events);
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
