<?php

namespace App\Repositories;

use App\Models\Year;

class YearRepository
{
  public function open(int $year)
  {
    if ($this->isTableEmpty()) {
      return Year::create(['year' => $year, 'date' => $year . '-04-01']);
    } else {
      $previousYear = $this->getPreviousYear($year);
      if ($previousYear->is_open) {
        throw new RepositoryException('Previous year is not closed.');
      } else {
        return Year::create(['year' => $year, 'date' => $year . '-04-01']);
      }
    }
  }

  public function getPreviousYear(int $year)
  {
    $yr = $this->getYearByYear($year - 1);
    if (!isset($yr)) {
      throw new RepositoryException('Previous year does not exist.');
    }
    return $yr;
  }

  public function getYearByYear(int $year)
  {
    return Year::firstWhere(['year' => $year]);
  }

  private function isTableEmpty(): bool
  {
    return Year::count() == 0 ? true : false;
  }

  public function setTaxOk($yearId)
  {
    $year = $this->getYearById($yearId);
    $year->tax_ok = true;
    $year->save();
  }

  public function getYearById($yearId)
  {
    $year = Year::find($yearId);
    if (!isset($year)) {
      throw new RepositoryException('Year does not exist in database.');
    }
    return $year;
  }

  public function isTaxOk($yearId)
  {
    $year = $this->getYearById($yearId);
    return $year->tax_ok ? true : false;
  }

  public function setDepreciationOk($yearId)
  {
    $year = $this->getYearById($yearId);
    $year->depreciation_ok = true;
    $year->save();
  }

  public function isDepreciationOk($yearId)
  {
    $year = $this->getYearById($yearId);
    return $year->depreciation_ok ? true : false;
  }

  public function setPlOk($yearId)
  {
    $year = $this->getYearById($yearId);
    $year->pl_ok = true;
    $year->save();
  }

  public function isPlOk($yearId)
  {
    $year = $this->getYearById($yearId);
    return $year->pl_ok ? true : false;
  }

  public function setPlaOk($yearId)
  {
    $year = $this->getYearById($yearId);
    $year->pla_ok = true;
    $year->save();
  }

  public function isPlaOk($yearId)
  {
    $year = $this->getYearById($yearId);
    return $year->pla_ok ? true : false;
  }

  public function close($yearId)
  {
    $year = $this->getYearById($yearId);
    if (!$year->is_open) {
      throw new RepositoryException('The year is already closed.');
    }
    if(!$year->tax_ok) {
      throw new RepositoryException('Tax is not calculated for the year.');
    }
    if(!$year->depreciation_ok) {
      throw new RepositoryException('Depreciation is not calculated for the year.');
    }
    if(!$year->pl_ok) {
      throw new RepositoryException('Profit & Loss is not calculated for the year.');
    }
    if(!$year->pla_ok) {
      throw new RepositoryException('Profit & Loss Appropriation is not calculated for the year.');
    }
    $year->is_open = false;
    $year->save();
  }
}
