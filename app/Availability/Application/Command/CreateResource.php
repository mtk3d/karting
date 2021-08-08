<?php

declare(strict_types=1);


namespace Karting\Availability\Application\Command;

use Karting\Availability\Domain\Slots;
use Karting\Shared\Common\Command;
use Karting\Shared\ResourceId;

class CreateResource implements Command
{
    private ResourceId $id;
    private Slots $slots;
    private bool $enabled;

    public function __construct(ResourceId $id, Slots $slots)
    {
        $this->id = $id;
        $this->slots = $slots;
        $this->enabled = true;
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
