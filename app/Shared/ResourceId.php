<?php

declare(strict_types=1);

namespace Karting\Shared;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Karting\Shared\Common\UUID;

class ResourceId extends AbstractId
{
    public static function of(string $id): ResourceId
    {
        return new ResourceId(new UUID($id));
    }

    public static function newOne(): ResourceId
    {
        return new ResourceId(UUID::random());
    }

    public function isEqual(ResourceId $id): bool
    {
        return $this->id->isEqual($id->id());
    }
}
