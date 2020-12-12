<?php

declare(strict_types=1);


namespace Tests\Feature\Availability;


use App\Availability\Application\AvailabilityFacade;
use App\Availability\Domain\ResourceAvailabilityException;
use App\Availability\Domain\ResourceRepository;
use App\Availability\Infrastructure\Repository\EloquentResourceRepository;
use App\Shared\DomainEventDispatcher;
use App\Shared\IlluminateDomainEventDispatcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function Tests\Fixtures\aResource;
use function Tests\Fixtures\aWithdrawnResource;

class AvailabilityTest extends TestCase
{
    use RefreshDatabase;

    private AvailabilityFacade $availabilityFacade;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        app()->bind(ResourceRepository::class, EloquentResourceRepository::class);
        app()->bind(DomainEventDispatcher::class, IlluminateDomainEventDispatcher::class);
        $this->availabilityFacade = app()->make(AvailabilityFacade::class);
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateResource(): void
    {
        $resource = aResource();
        $this->availabilityFacade->createResource($resource->getId());

        $this->assertDatabaseHas('resource_items', [
            'id' => $resource->getId()->id(),
        ]);
    }

    public function testWithdrawResource(): void
    {
        // given
        $resource = aResource();
        $resource->save();

        // when
        $this->availabilityFacade->withdrawResource($resource->getId());

        // then
        $this->assertDatabaseHas('resource_items', [
            'id' => $resource->getId()->id(),
            'is_available' => false
        ]);
    }

    public function testWithdrawWithdrawnResource(): void
    {
        // given
        $resource = aWithdrawnResource();
        $resource->save();

        // should
        self::expectExceptionObject(new ResourceAvailabilityException('ResourceItem already withdrawn'));

        // when
        $this->availabilityFacade->withdrawResource($resource->getId());
    }

    public function testTurnOnWithdrawnResource(): void
    {
        // given
        $resource = aWithdrawnResource();
        $resource->save();

        // when
        $this->availabilityFacade->turnOnResource($resource->getId());

        // then
        $this->assertDatabaseHas('resource_items', [
            'id' => $resource->getId()->id(),
            'is_available' => true
        ]);
    }

    public function testTurnOnResource(): void
    {
        // given
        $resource = aResource();
        $resource->save();

        // should
        self::expectExceptionObject(new ResourceAvailabilityException('ResourceItem already turned on'));

        // when
        $this->availabilityFacade->turnOnResource($resource->getId());
    }
}
