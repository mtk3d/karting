<?php

declare(strict_types=1);

namespace Karting\Kart\Application;

use Karting\Kart\Application\Command\CreateKart;
use Karting\Kart\Kart;
use Karting\Kart\KartCatalog;
use Karting\Kart\KartCreated;
use Karting\Shared\Common\DomainEventBus;
use Karting\Shared\ResourceCreated;
use Karting\Shared\ResourceId;

class CreateKartHandler
{
    private KartCatalog $catalog;
    private DomainEventBus $bus;

    public function __construct(KartCatalog $kartCatalog, DomainEventBus $eventBus)
    {
        $this->catalog = $kartCatalog;
        $this->bus = $eventBus;
    }

    public function handle(CreateKart $createKart): void
    {
        $kart = new Kart([
            'uuid' => $createKart->id(),
            'name' => $createKart->name(),
            'description' => $createKart->description()
        ]);

        $this->catalog->add($kart);

        $resourceCreated = ResourceCreated::newOne(ResourceId::of($createKart->id()->toString()), 1);
        $kartCreated = KartCreated::newOne($createKart->id(), $createKart->name(), $createKart->description());

        $this->bus->dispatch($kartCreated);
        $this->bus->dispatch($resourceCreated);
    }
}
