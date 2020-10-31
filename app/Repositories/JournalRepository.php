<?php

namespace App\Repositories;

use App\Models\Journal;

class JournalRepository
{
  public function create($date, $yearId)
  {
    return Journal::create([
      'date' => $date,
      'year_id' => $yearId
    ]);
  }

  public function latest()
  {
    return Journal::oldest()->first();
  }
}
