<?php

namespace Tests\Feature\Repositories;

use App\Repositories\DepreciationRepository;
use App\Repositories\RepositoryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepreciationRepositoryTest extends TestCase
{
  use RefreshDatabase;
  use WithFaker;

  private function getSut(): DepreciationRepository
  {
    return app()->make(DepreciationRepository::class);
  }

  public function test_create_creates_with_zeros()
  {
    $ledgerId = $this->faker->randomNumber();
    $repo = $this->getSut();
    $repo->create($ledgerId);
    $this->assertDatabaseHas('depreciations', [
      'ledger_id' => $ledgerId,
      'rate' => 0,
      'amount' => 0,
      'buy_first' => 0,
      'buy_last' => 0,
      'sell_first' => 0,
      'sell_last' => 0
    ]);
  }

  public function test_update_rate_throws_repository_exception_if_depreciation_id_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $depId = $this->faker->randomNumber();;
    $rate = $this->faker->numberBetween(5, 100);
    $repo = $this->getSut();
    $repo->updateRate($depId, $rate);
  }

  public function test_update_rate()
  {
    $ledgerId = $this->faker->randomNumber();
    $rate = $this->faker->numberBetween(5, 100);
    $repo = $this->getSut();
    $depreciation = $repo->create($ledgerId);
    $repo->updateRate($depreciation->id, $rate);

    $depreciation->refresh();

    $this->assertEquals($rate, $depreciation->rate);
  }

  public function test_update_amount_throws_repository_exception_if_depreciation_id_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $depId = $this->faker->randomNumber();
    $amount = $this->faker->randomNumber();
    $repo = $this->getSut();
    $repo->updateAmount($depId, $amount);
  }
  
  public function test_update_amount()
  {
    $ledgerId = $this->faker->randomNumber();
    $amount = $this->faker->randomNumber();
    $repo = $this->getSut();
    $depreciation = $repo->create($ledgerId);
    $repo->updateAmount($depreciation->id, $amount);

    $depreciation->refresh();

    $this->assertEquals($amount, $depreciation->amount);
  }

  public function test_update_buyFirst_throws_repository_exception_if_depreciation_id_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $depId = $this->faker->randomNumber();
    $buyFirst = $this->faker->randomNumber();
    $repo = $this->getSut();
    $repo->updateBuyFirst($depId, $buyFirst);
  }
  
  public function test_update_buyFirst()
  {
    $ledgerId = $this->faker->randomNumber();
    $buyFirst = $this->faker->randomNumber();
    $repo = $this->getSut();
    $depreciation = $repo->create($ledgerId);
    $repo->updateBuyFirst($depreciation->id, $buyFirst);

    $depreciation->refresh();

    $this->assertEquals($buyFirst, $depreciation->buy_first);
  }

  public function test_update_buyLast_throws_repository_exception_if_depreciation_id_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $depId = $this->faker->randomNumber();
    $buyLast = $this->faker->randomNumber();
    $repo = $this->getSut();
    $repo->updateBuyLast($depId, $buyLast);
  }
  
  public function test_update_buyLast()
  {
    $ledgerId = $this->faker->randomNumber();
    $buyLast = $this->faker->randomNumber();
    $repo = $this->getSut();
    $depreciation = $repo->create($ledgerId);
    $repo->updateBuyLast($depreciation->id, $buyLast);

    $depreciation->refresh();

    $this->assertEquals($buyLast, $depreciation->buy_last);
  }

  public function test_update_sellFirst_throws_repository_exception_if_depreciation_id_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $depId = $this->faker->randomNumber();
    $sellFirst = $this->faker->randomNumber();
    $repo = $this->getSut();
    $repo->updateSellFirst($depId, $sellFirst);
  }
  
  public function test_update_sellFirst()
  {
    $ledgerId = $this->faker->randomNumber();
    $sellFirst = $this->faker->randomNumber();
    $repo = $this->getSut();
    $depreciation = $repo->create($ledgerId);
    $repo->updateSellFirst($depreciation->id, $sellFirst);

    $depreciation->refresh();

    $this->assertEquals($sellFirst, $depreciation->sell_first);
  }

  public function test_update_sellLast_throws_repository_exception_if_depreciation_id_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $depId = $this->faker->randomNumber();
    $sellLast = $this->faker->randomNumber();
    $repo = $this->getSut();
    $repo->updateSellLast($depId, $sellLast);
  }
  
  public function test_update_sellLast()
  {
    $ledgerId = $this->faker->randomNumber();
    $sellLast = $this->faker->randomNumber();
    $repo = $this->getSut();
    $depreciation = $repo->create($ledgerId);
    $repo->updateSellLast($depreciation->id, $sellLast);

    $depreciation->refresh();

    $this->assertEquals($sellLast, $depreciation->sell_last);
  }
}
