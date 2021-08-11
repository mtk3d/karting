<?php

declare(strict_types=1);

namespace Karting\Availability\Application\Command;

use Karting\Shared\Common\Command;
use Karting\Shared\ResourceId;

class UpdateSlots implements Command
{
    public function __construct(
        private ResourceId $id,
        private int $slots
    ) {
    }

    public function id(): ResourceId
    {
        return $this->id;
    }

    public function slots(): int
    {
        return $this->slots;
    }
}
