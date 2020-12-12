<?php

declare(strict_types=1);

namespace App\Shared;

use App\Shared\Result\Failure;
use App\Shared\Result\Success;
use Illuminate\Support\Collection;

abstract class Result
{
    /**
     * @param Collection<int, DomainEvent> $events
     * @return Success
     */
    public static function success(?Collection $events = null): Success
    {
        if ($events === null) {
            $events = new Collection();
        }
        return new Success($events);
    }

    public static function failure(string $reason): Failure
    {
        return new Failure($reason);
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
     * @return Collection|DomainEvent
     *
     * @psalm-return Collection<empty, empty>|DomainEvent
     */
    public function events()
    {
        if ($this->isSuccessful()) {
            return $this->events;
        }

        return new Collection();
    }
}
