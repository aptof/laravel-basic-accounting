<?php

namespace Tests\Feature\Repositories;

use App\Repositories\JournalRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JournalRepositoryTest extends TestCase
{
  use RefreshDatabase;
  use WithFaker;

  private function getSut(): JournalRepository
  {
    return app()->make(JournalRepository::class);
  }

  public function test_create_creates_entry_in_database()
  {
    $yearId = $this->faker->randomNumber();
    $date = $this->faker->date();
    $repo = $this->getSut();
    $repo->create($date, $yearId);
    $this->assertDatabaseHas('journals', ['date' => $date, 'year_id' => $yearId]);
  }

  public function test_latest_returns_the_last_entry()
  {
    $yearId1 = $this->faker->randomNumber();
    $date1 = $this->faker->date();
    $yearId2 = $this->faker->randomNumber();
    $date2 = $this->faker->date();
    $yearId3 = $this->faker->randomNumber();
    $date3 = $this->faker->date();

    $repo = $this->getSut();
    $repo->create($date1, $yearId1);
    $repo->create($date2, $yearId2);
    $repo->create($date3, $yearId3);

    $latest = $repo->latest();
    $this->assertEquals($date3, $latest->date);
    $this->assertEquals($yearId3, $latest->year_id);
  }
}
