<?php

declare(strict_types=1);


namespace App\Availability\Application\Command;

use App\Availability\Domain\Slots;
use App\Shared\Common\Command;
use App\Shared\ResourceId;

class CreateResource implements Command
{
    private ResourceId $id;
    private Slots $slots;
    private bool $isAvailable;

    public function __construct(ResourceId $id, Slots $slots, bool $isAvailable)
    {
        $this->id = $id;
        $this->slots = $slots;
        $this->isAvailable = $isAvailable;
    }

    public function id(): ResourceId
    {
        return $this->id;
    }

    public function slots(): Slots
    {
        return $this->slots;
    }

    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }
}
