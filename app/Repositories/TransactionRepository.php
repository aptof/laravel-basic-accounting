<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
  public function create($ledgerId, $journalId, $amount, $isDr, $balance)
  {
    return Transaction::create([
      'ledger_id' => $ledgerId,
      'journal_id' => $journalId,
      'amount' => $amount,
      'is_dr' => $isDr,
      'balance' => $balance
    ]);
  }

  public function deleteByJournalId($journalId)
  {
    Transaction::where('journal_id', $journalId)->delete();
  }
}
