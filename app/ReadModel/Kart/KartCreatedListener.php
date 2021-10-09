<?php

declare(strict_types=1);

namespace App\ReadModel\Kart;

use Karting\Kart\KartCreated;

class KartCreatedListener
{
    public function handle(KartCreated $kartCreated): void
    {
        Kart::create([
            'uuid' => $kartCreated->id()->toString(),
            'name' => $kartCreated->name(),
            'description' => $kartCreated->description(),
        ]);
    }
}
