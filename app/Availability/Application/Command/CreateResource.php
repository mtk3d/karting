<?php

declare(strict_types=1);


namespace App\Availability\Application\Command;


use App\Shared\ResourceId;

class CreateResource
{
    private ResourceId $id;
    private bool $isAvailable;

    public function __construct(ResourceId $id, bool $isAvailable)
    {
        $this->id = $id;
        $this->isAvailable = $isAvailable;
    }

    public function id(): ResourceId
    {
        return $this->id;
    }

    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }
}
