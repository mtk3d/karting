<?php

declare(strict_types=1);

namespace App\Shared;

use App\Shared\Common\UUID;

class ResourceId
{
    private UUID $id;

    public function __construct(UUID $id)
    {
        $this->id = $id;
    }

    public static function of(string $id): ResourceId
    {
        return new ResourceId(new UUID($id));
    }

    public function id(): UUID
    {
        return $this->id;
    }

    public static function newOne(): self
    {
        return new self(UUID::random());
    }

    public function isEqual(self $id): bool
    {
        return $this->id->isEqual($id->id);
    }

    public function __toString()
    {
        return sprintf('ResourceId{id=%s}', $this->id);
    }
}
