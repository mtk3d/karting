<?php

declare(strict_types=1);

namespace Karting\Pricing\Domain;

use Illuminate\Database\Eloquent\Model;
use Karting\Pricing\Infrastructure\Repository\Eloquent\PriceCast;
use Karting\Shared\Common\UUID;
use Karting\Shared\Common\UUIDCast;

/**
 * @property UUID $uuid
 * @property Price $price
 */
class PricedItem extends Model
{
    protected $fillable = [
        'uuid',
        'price'
    ];

    protected $casts = [
        'uuid' => UUIDCast::class,
        'price' => PriceCast::class
    ];

    public static function of(UUID $id, Price $price): PricedItem
    {
        return new PricedItem([
            'uuid' => $id,
            'price' => $price
        ]);
    }

    public function id(): UUID
    {
        return $this->uuid;
    }

    public function price(): Price
    {
        return $this->price;
    }
}
