<?php

namespace App\Repositories;

use App\Models\Ledger;

class LedgerRepository
{
  public function create($yearId, $definitionId, $balance)
  {
    $this->checkIfExist($yearId, $definitionId);
    return Ledger::create([
      'year_id' => $yearId,
      'ledger_definition_id' => $definitionId,
      'balance' => $balance,
      'opening_balance' => $balance
    ]);
  }

  private function checkIfExist($yearId, $definitionId)
  {
    $ledger = Ledger::firstWhere([
      ['year_id', $yearId],
      ['ledger_definition_id', $definitionId]
    ]);
    if (isset($ledger)) {
      throw new RepositoryException('Ledger for the same year and definition already exist.');
    }
  }

  public function updateBalance($ledgerId, $newBalance)
  {
    $ledger = Ledger::find($ledgerId);
    if (!isset($ledger)) {
      throw new RepositoryException('Ledger does not exist.');
    }
    $ledger->balance = $newBalance;
    $ledger->save();
  }
}
