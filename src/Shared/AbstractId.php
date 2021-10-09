<?php

declare(strict_types=1);

namespace Karting\Shared;

use Karting\Shared\Common\UUID;
use Stringable;

abstract class AbstractId implements Stringable
{
    public function __construct(protected UUID $id)
    {
    }

    public function id(): UUID
    {
        return $this->id;
    }

    public function toString(): string
    {
        return $this->id->toString();
    }

    public function __toString()
    {
        return $this->toString();
    }
}
