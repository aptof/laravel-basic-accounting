<?php

namespace Tests\Feature\Repositories;

use App\Repositories\RepositoryException;
use App\Repositories\YearRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class YearRepositoryTest extends TestCase
{
  use RefreshDatabase;

  private function getSut(): YearRepository
  {
    return app()->make(YearRepository::class);
  }

  public function test_open_makes_entry_in_database_if_first()
  {
    $repo = $this->getSut();
    $repo->open(2020);
    $this->assertDatabaseHas('years', [
      'year' => 2020,
      'is_open' => true,
      'date' => '2020-04-01',
      'tax_ok' => false,
      'depreciation_ok' => false,
      'pl_ok' => false,
      'pla_ok' => false
    ]);
  }

  public function test_open_if_year_is_not_first_throws_exception_if_previous_year_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Previous year does not exist.');
    $repo = $this->getSut();
    $repo->open(2018);
    $repo->open(2020);
  }

  public function test_open_if_year_is_not_first_throws_exception_if_previous_year_exist_but_is_open()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Previous year is not closed.');
    $repo = $this->getSut();
    $repo->open(2019);
    $repo->open(2020);
  }

  public function test_open_if_year_is_not_first_open_if_previous_year_is_closed()
  {
    $repo = $this->getSut();
    $previousYear = $repo->open(2020);
    $repo->setTaxOk($previousYear->id);
    $repo->setDepreciationOk($previousYear->id);
    $repo->setPlOk($previousYear->id);
    $repo->setPlaOk($previousYear->id);
    $repo->close($previousYear->id);
    $repo->open(2021);
    $this->assertDatabaseHas('years', [
      'year' => 2021,
      'is_open' => true,
      'date' => '2021-04-01',
      'tax_ok' => false,
      'depreciation_ok' => false,
      'pl_ok' => false,
      'pla_ok' => false
    ]);
  }

  public function test_setTaxOk_throws_exception_if_year_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Year does not exist in database.');
    $repo = $this->getSut();
    $repo->setTaxOk(3);
  }

  public function test_setTaxOk()
  {
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $repo->setTaxOk($year->id);

    $year->refresh();
    $this->assertEquals(1, $year->tax_ok);
  }

  public function test_isTaxOk_throws_exception_if_year_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Year does not exist in database.');
    $repo = $this->getSut();
    $repo->isTaxOk(3);
  }

  public function test_isTaxOk_returns_false()
  {
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $this->assertFalse($repo->isTaxOk($year->id));
  }

  public function test_isTaxOk_returns_true()
  {
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $repo->setTaxOk($year->id);
    $this->assertTrue($repo->isTaxOk($year->id));
  }

  public function test_setDepreciationOk_throws_exception_if_year_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Year does not exist in database.');
    $repo = $this->getSut();
    $repo->setDepreciationOk(3);
  }

  public function test_setDepreciationOk()
  {
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $repo->setDepreciationOk($year->id);

    $year->refresh();
    $this->assertEquals(1, $year->depreciation_ok);
  }

  public function test_isDepreciationOk_throws_exception_if_year_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Year does not exist in database.');
    $repo = $this->getSut();
    $repo->isDepreciationOk(3);
  }

  public function test_isDepreciationOk_returns_false()
  {
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $this->assertFalse($repo->isDepreciationOk($year->id));
  }

  public function test_isDepreciationOk_returns_true()
  {
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $repo->setDepreciationOk($year->id);
    $this->assertTrue($repo->isDepreciationOk($year->id));
  }

  public function test_setPlOk_throws_exception_if_year_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Year does not exist in database.');
    $repo = $this->getSut();
    $repo->setPlOk(3);
  }

  public function test_setPlOk()
  {
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $repo->setPlOk($year->id);

    $year->refresh();
    $this->assertEquals(1, $year->pl_ok);
  }

  public function test_isPlOk_throws_exception_if_year_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Year does not exist in database.');
    $repo = $this->getSut();
    $repo->isPlOk(3);
  }

  public function test_isPlOk_returns_false()
  {
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $this->assertFalse($repo->isPlOk($year->id));
  }

  public function test_isPlOk_returns_true()
  {
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $repo->setPlOk($year->id);
    $this->assertTrue($repo->isPlOk($year->id));
  }

  public function test_setPlaOk_throws_exception_if_year_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Year does not exist in database.');
    $repo = $this->getSut();
    $repo->setPlaOk(3);
  }

  public function test_setPlaOk()
  {
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $repo->setPlaOk($year->id);

    $year->refresh();
    $this->assertEquals(1, $year->pla_ok);
  }

  public function test_isPlaOk_throws_exception_if_year_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Year does not exist in database.');
    $repo = $this->getSut();
    $repo->isPlaOk(3);
  }

  public function test_isPlaOk_returns_false()
  {
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $this->assertFalse($repo->isPlaOk($year->id));
  }

  public function test_isPlaOk_returns_true()
  {
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $repo->setPlaOk($year->id);
    $this->assertTrue($repo->isPlaOk($year->id));
  }

  public function test_close_throws_exception_if_year_does_not_exist()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Year does not exist in database.');
    $repo = $this->getSut();
    $repo->close(5);
  }

  public function test_close_closes_year()
  {
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $repo->setTaxOk($year->id);
    $repo->setDepreciationOk($year->id);
    $repo->setPlaOk($year->id);
    $repo->setPlOk($year->id);
    $repo->close($year->id);
    $year->refresh();
    $this->assertEquals(0, $year->is_open);
  }

  public function test_close_throws_exception_if_year_is_already_closed()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('The year is already closed.');
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $repo->setTaxOk($year->id);
    $repo->setDepreciationOk($year->id);
    $repo->setPlaOk($year->id);
    $repo->setPlOk($year->id);
    $repo->close($year->id);
    $repo->close($year->id);
  }

  public function test_close_throws_exception_if_years_gst_is_not_ok()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Tax is not calculated for the year.');
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $repo->close($year->id);
  }

  public function test_close_throws_exception_if_years_depreciation_is_not_ok()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Depreciation is not calculated for the year.');
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $repo->setTaxOk($year->id);
    $repo->close($year->id);
  }

  public function test_close_throws_exception_if_years_pl_is_not_ok()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Profit & Loss is not calculated for the year.');
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $repo->setTaxOk($year->id);
    $repo->setDepreciationOk($year->id);
    $repo->close($year->id);
  }

  public function test_close_throws_exception_if_years_pla_is_not_ok()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Profit & Loss Appropriation is not calculated for the year.');
    $repo = $this->getSut();
    $year = $repo->open(2020);
    $repo->setTaxOk($year->id);
    $repo->setDepreciationOk($year->id);
    $repo->setPlOk($year->id);
    $repo->close($year->id);
  }
}
