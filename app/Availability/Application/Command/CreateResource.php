<?php

declare(strict_types=1);


namespace Karting\Availability\Application\Command;

use Karting\Availability\Domain\Slots;
use Karting\Shared\Common\Command;
use Karting\Shared\ResourceId;

class CreateResource implements Command
{
    public function __construct(
        private ResourceId $id,
        private Slots $slots,
        private bool $enabled
    ) {
    }

    public function id(): ResourceId
    {
        return $this->id;
    }

    public function slots(): Slots
    {
        return $this->slots;
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }
}
