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
    private PricedItemRepository $repository;
    private DomainEventBus $bus;

    public function __construct(PricedItemRepository $repository, DomainEventBus $bus)
    {
        $this->repository = $repository;
        $this->bus = $bus;
    }

    public function handle(SetPrice $setPrice): void
    {
        $resourceItem = PricedItem::of($setPrice->id(), new Price($setPrice->price()));
        $this->repository->save($resourceItem);
        $this->bus->dispatch(PriceSet::newOne($setPrice->id(), $setPrice->price()));
    }
}
