<?php

declare(strict_types=1);

namespace Karting\Pricing\Application;

use Karting\Pricing\Application\Command\SetPrice;
use Karting\Pricing\Domain\Price;
use Karting\Pricing\Domain\PriceSet;
use Karting\Pricing\Domain\PricedItem;
use Karting\Pricing\Domain\PricedItemRepository;
use Karting\Shared\Common\DomainEventBus;

class SetPriceHandler
{
    public function __construct(private PricedItemRepository $repository, private DomainEventBus $bus)
    {
    }

    public function handle(SetPrice $setPrice): void
    {
        $resourceItem = PricedItem::of($setPrice->id(), $setPrice->price());
        $this->repository->save($resourceItem);
        $this->bus->dispatch(PriceSet::newOne($setPrice->id(), $setPrice->price()->money()));
    }
}
