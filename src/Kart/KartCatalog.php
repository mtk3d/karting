<?php

declare(strict_types=1);

namespace Karting\Kart;

class KartCatalog
{
    public function add(Kart $kart): void
    {
        $kart->save();
    }
}
