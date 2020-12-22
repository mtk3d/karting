<?php

declare(strict_types=1);


namespace App\Availability\Application\Command;

use App\Shared\Common\Command;
use App\Shared\ResourceId;

class TurnOnResource implements Command
{
    private ResourceId $id;

    public function __construct(ResourceId $id)
    {
        $this->id = $id;
    }

    public function id(): ResourceId
    {
        return $this->id;
    }
}
