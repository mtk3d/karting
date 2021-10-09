<?php

declare(strict_types=1);

namespace Karting\Availability\Application\Command;

use Karting\Shared\Common\Command;
use Karting\Shared\ResourceId;

class SetState implements Command
{
    public function __construct(
        private ResourceId $id,
        private bool $enabled
    ) {
    }

    public function id(): ResourceId
    {
        return $this->id;
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }
}
