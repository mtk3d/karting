<?php


namespace Tests\Feature\RaceSchedule;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class RaceScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function testSchedulingNewRace()
    {
        $this->scheduleRace('2019-12-06 15:00', '2019-12-28 15:00', ['monday', 'friday']);
        $this->scheduleRace('2020-12-06 15:00', '2020-12-28 15:00', ['monday', 'friday']);
        $this->scheduleRace('2020-12-06 18:00', '2021-01-28 18:00', ['tuesday', 'wednesday']);

        $response = $this->get('api/event?from=2020-12-15&to=2021-12-22');
    }

    private function scheduleRace(string $from, string $to, array $days): TestResponse
    {
        $response = $this->post('api/event', [
            'start_date' => $from,
            'end_date' => $to,
            'days' => $days
        ]);

        $response->assertCreated();

        return $response;
    }
}
