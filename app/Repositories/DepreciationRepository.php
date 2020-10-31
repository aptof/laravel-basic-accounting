<?php

namespace App\Repositories;

use App\Models\Depreciation;

class DepreciationRepository
{
  public function create($ledgerId)
  {
    return Depreciation::create([
      'ledger_id' => $ledgerId
    ]);
  }

  public function updateRate($id, $rate)
  {
    $depreciation = $this->getById($id);
    $depreciation->rate = $rate;
    $depreciation->save();
  }

  public function getById($id): Depreciation
  {
    $depreciation = Depreciation::find($id);
    if (isset($depreciation)) {
      return $depreciation;
    } else {
      throw new RepositoryException('Depreciation does not exist in database');
    }
  }

  public function updateAmount($id, $amount)
  {
    $depreciation = $this->getById($id);
    $depreciation->amount = $amount;
    $depreciation->save();
  }

  public function updateBuyFirst($id, $amount)
  {
    $depreciation = $this->getById($id);
    $depreciation->buy_first = $amount;
    $depreciation->save();
  }

  public function updateBuyLast($id, $amount)
  {
    $depreciation = $this->getById($id);
    $depreciation->buy_last = $amount;
    $depreciation->save();
  }

  public function updateSellFirst($id, $amount)
  {
    $depreciation = $this->getById($id);
    $depreciation->sell_first = $amount;
    $depreciation->save();
  }

  public function updateSellLast($id, $amount)
  {
    $depreciation = $this->getById($id);
    $depreciation->sell_last = $amount;
    $depreciation->save();
  }
}
