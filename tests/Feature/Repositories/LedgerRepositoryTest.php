<?php

namespace Tests\Feature\Repositories;

use App\Repositories\LedgerRepository;
use App\Repositories\RepositoryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LedgerRepositoryTest extends TestCase
{
  use RefreshDatabase;
  use WithFaker;

  private function getSut(): LedgerRepository
  {
    return app()->make(LedgerRepository::class);
  }

  public function test_create_creates_entry_in_database()
  {
    $year_id = $this->faker->numberBetween(1);
    $definition_id = $this->faker->numberBetween(1);
    $balance = $this->faker->randomNumber();
    $repo = $this->getSut();
    $repo->create($year_id, $definition_id, $balance);
    $this->assertDatabaseHas('ledgers', ['year_id' => $year_id, 'ledger_definition_id' => $definition_id, 'balance' => $balance, 'opening_balance' => $balance]);
  }

  public function test_create_throws_repository_exception_if_ledger_exist_for_the_same_year_and_definition()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Ledger for the same year and definition already exist.');
    $year_id = $this->faker->numberBetween(1);
    $definition_id = $this->faker->numberBetween(1);
    $balance = $this->faker->randomNumber();
    $repo = $this->getSut();
    $repo->create($year_id, $definition_id, $balance);
    $repo->create($year_id, $definition_id, $balance);
  }

  public function test_updateBalance_updates_balance()
  {
    $year_id = $this->faker->numberBetween(1);
    $definition_id = $this->faker->numberBetween(1);
    $balance = $this->faker->randomNumber();
    $repo = $this->getSut();
    $ledger = $repo->create($year_id, $definition_id, $balance);
    $newBalance = $this->faker->randomNumber();
    $repo->updateBalance($ledger->id, $newBalance);

    $this->assertDatabaseHas('ledgers', ['id' => $ledger->id, 'balance' => $newBalance]);
  }

  public function test_updateBalance_throws_repository_exception_of_ledger_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Ledger does not exist.');
    $id = $this->faker->randomNumber();
    $repo = $this->getSut();
    $newBalance = $this->faker->randomNumber();
    $repo->updateBalance($id, $newBalance);
  }
}
