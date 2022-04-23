<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use Carbon\CarbonPeriod;
use Karting\Shared\Common\Result;
use Karting\Shared\ReservationId;
use Karting\Shared\ResourceId;

class Reservation
{
    public function __construct(
        private $model
    ) {}

    public function model()
    {
        return $this->model;
    }

    public function id(): ReservationId
    {
        return $this->model->uuid;
    }

    public function period(): CarbonPeriod
    {
        return $this->model->period;
    }

    public function status(): Status
    {
        return $this->model->status;
    }

    public function isConfirmed(): bool
    {
        return $this->model->status->equals(Status::CONFIRMED());
    }

    public function isFinished(): bool
    {
        return $this->model->track->reserved() && $this->allKartsReserved();
    }

    private function allKartsReserved(): bool
    {
        return $this->model->karts
            ->filter(fn (Kart $kart): bool => !$kart->reserved())
            ->isEmpty();
    }

    /**
     * @throws ReservationConfirmationException
     */
    public function confirm(): Result
    {
        if ($this->model->status->equals(Status::CANCELED())) {
            throw new ReservationConfirmationException('ResourceReservation is canceled');
        }

        if ($this->model->status->equals(Status::CONFIRMED())) {
            throw new ReservationConfirmationException('ResourceReservation is already confirmed');
        }

        $this->model->status = Status::CONFIRMED();

        return Result::success(
            ReservationStatusChanged::newOne($this->model->uuid, $this->model->status)
        );
    }

    public function cancel(): void
    {
        $this->model->status = Status::CANCELED();
    }

    public function updateProgress(ResourceId $resourceId): void
    {
        if ($this->model->karts->contains(new Kart($resourceId, false))) {
            $this->model->karts = $this->model->karts->map(function (Kart $kart) use ($resourceId): Kart {
                if ($kart->resourceId()->isEqual($resourceId)) {
                    $kart->reserve();
                }

                return $kart;
            });
        }

        if ($this->model->track->resourceId()->isEqual($resourceId)) {
            $this->model->track->reserve();
        }
    }
}
