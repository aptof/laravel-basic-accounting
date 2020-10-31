<?php

namespace Tests\Feature\Repositories;

use App\Repositories\TransactionRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionRepositoryTest extends TestCase
{
  use RefreshDatabase;
  use WithFaker;

  private function getSut(): TransactionRepository
  {
    return app()->make(TransactionRepository::class);
  }

  public function test_create_in_database()
  {
    $ledgerId = $this->faker->randomNumber();
    $journalId = $this->faker->randomNumber();
    $amount = $this->faker->randomNumber();
    $isDr = $this->faker->boolean();
    $balance = $this->faker->randomNumber();

    $repo = $this->getSut();
    $repo->create($ledgerId, $journalId, $amount, $isDr, $balance);

    $this->assertDatabaseHas('transactions', [
      'ledger_id' => $ledgerId,
      'journal_id' => $journalId,
      'amount' => $amount,
      'is_dr' => $isDr,
      'balance' => $balance
    ]);
  }

  public function test_delete_By_Journal_deletes()
  {
    $journalId1 = $this->faker->randomNumber();
    $journalId2 = $this->faker->randomNumber();

    $ledgerId1 = $this->faker->randomNumber();
    $amount1 = $this->faker->randomNumber();
    $isDr1 = $this->faker->boolean();
    $balance1 = $this->faker->randomNumber();

    $ledgerId2 = $this->faker->randomNumber();
    $amount2 = $this->faker->randomNumber();
    $isDr2 = $this->faker->boolean();
    $balance2 = $this->faker->randomNumber();

    $ledgerId3 = $this->faker->randomNumber();
    $amount3 = $this->faker->randomNumber();
    $isDr3 = $this->faker->boolean();
    $balance3 = $this->faker->randomNumber();

    $ledgerId4 = $this->faker->randomNumber();
    $amount4 = $this->faker->randomNumber();
    $isDr4 = $this->faker->boolean();
    $balance4 = $this->faker->randomNumber();

    $repo = $this->getSut();
    $repo->create($ledgerId1, $journalId1, $amount1, $isDr1, $balance1);
    $repo->create($ledgerId2, $journalId1, $amount2, $isDr2, $balance2);
    $repo->create($ledgerId3, $journalId2, $amount3, $isDr3, $balance3);
    $repo->create($ledgerId4, $journalId2, $amount4, $isDr4, $balance4);

    $repo->deleteByJournalId($journalId1);

    $this->assertDatabaseMissing('transactions', [
      'ledger_id' => $ledgerId1,
      'journal_id' => $journalId1,
      'amount' => $amount1,
      'is_dr' => $isDr1,
      'balance' => $balance1
    ]);

    $this->assertDatabaseMissing('transactions', [
      'ledger_id' => $ledgerId2,
      'journal_id' => $journalId1,
      'amount' => $amount2,
      'is_dr' => $isDr2,
      'balance' => $balance2
    ]);
  }
}
