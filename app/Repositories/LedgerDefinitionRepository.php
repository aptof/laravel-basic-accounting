<?php

namespace App\Repositories;

use App\Models\LedgerDefinition;

class LedgerDefinitionRepository
{
  public function create($name, $type, $rate = null): LedgerDefinition
  {
    if($type == 'Tax' && $rate == null)
    {
      throw new RepositoryException('Rate should be provided for the tax type definition.');
    }
    return LedgerDefinition::create([
      'name' => $name,
      'type' => $type,
      'rate' => $rate
    ]);
  }
}
