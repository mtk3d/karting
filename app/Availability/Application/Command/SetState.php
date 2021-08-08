<?php

declare(strict_types=1);

namespace Karting\Availability\Application\Command;

use Karting\Shared\Common\Command;
use Karting\Shared\ResourceId;

class SetState implements Command
{
    private ResourceId $id;
    private bool $enabled;

    public function __construct(ResourceId $id, bool $enabled)
    {
        $this->id = $id;
        $this->enabled = $enabled;
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
