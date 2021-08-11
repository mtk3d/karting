<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use Karting\Shared\Common\Result;
use Karting\Shared\ReservationId;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Reservation extends Model
{
    protected $fillable = [
        'uuid',
        'karts',
        'track',
        'from',
        'to',
        'confirmed'
    ];

    protected $attributes = [
        'karts' => [],
        'confirmed' => false
    ];

    protected $casts = [
        'confirmed' => 'boolean'
    ];

    public static function of(ReservationId $reservationId, Collection $karts, Track $track, CarbonPeriod $period): Reservation
    {
        return new Reservation([
            'uuid' => $reservationId->id()->toString(),
            'karts' => json_encode($karts->toArray()),
            'track' => json_encode($track),
            'from' => $period->getStartDate()->toDateTimeString(),
            'to' => $period->getEndDate()->toDateTimeString(),
        ]);
    }

    public function confirm(): Result
    {
        if ($this->attributes['confirmed']) {
            throw new \Exception('ResourceReservation is already confirmed');
        }

        $this->attributes['confirmed'] = true;

        $events = new Collection([
            ReservationConfirmed::newOne(ReservationId::of($this->attributes['uuid']))
        ]);

        return Result::success($events);
    }

    public function id(): ReservationId
    {
        return ReservationId::of($this->attributes['uuid']);
    }

    public function karts(): Collection
    {
        $karts = new Collection(json_decode($this->attributes['karts'], true));
        return $karts->map(fn (array $payload): Kart => Kart::fromArray($payload));
    }

    public function reserveTrack(): void
    {
        $track = $this->track();
        $track->reserve();
        $this->attributes['track'] = json_encode($track);
    }

    public function confirmed(): bool
    {
        return (bool)$this->attributes['confirmed'];
    }

    public function period(): CarbonPeriod
    {
        return new CarbonPeriod($this->attributes['from'], $this->attributes['to']);
    }

    private function track(): Track
    {
        return Track::fromArray(json_decode($this->attributes['track'], true));
    }

    public function updateProgress(ResourceId $resourceId): void
    {
        $karts = $this->karts();
        if ($karts->contains(new Kart($resourceId, false))) {
            $karts = $karts->map(function (Kart $kart) use ($resourceId): Kart {
                if ($kart->resourceId()->isEqual($resourceId)) {
                    $kart->reserve();
                }

                return $kart;
            });

            $this->attributes['karts'] = json_encode($karts->toArray());
        }

        $track = $this->track();
        if ($track->resourceId()->isEqual($resourceId)) {
            $track->reserve();
            $this->attributes['track'] = json_encode($track);
        }
    }

    public function finished(): bool
    {
        return $this->track()->reserved() && $this->kartsReserved();
    }

    private function kartsReserved(): bool
    {
        return 0 === $this->karts()->filter(fn (Kart $kart): bool => !$kart->reserved())->count();
    }
}
