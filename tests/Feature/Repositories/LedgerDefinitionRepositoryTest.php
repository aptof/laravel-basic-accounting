<?php

namespace Tests\Feature\Repositories;

use App\Repositories\LedgerDefinitionRepository;
use App\Repositories\RepositoryException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LedgerDefinitionRepositoryTest extends TestCase
{
  use RefreshDatabase;

  private function getSut(): LedgerDefinitionRepository
  {
    return app()->make(LedgerDefinitionRepository::class);
  }

  public function test_create_in_database()
  {
    $repo = $this->getSut();
    $repo->create('Cash', 'Other Asset');
    $this->assertDatabaseHas('ledger_definitions', ['name' => 'Cash', 'type' => 'Other Asset']);
  }

  public function test_create_throws_exception_if_duplicate_name()
  {
    $this->expectException(QueryException::class);
    $repo = $this->getSut();
    $repo->create('Cash', 'Other Asset');
    $repo->create('Cash', 'Other Asset');
  }

  public function test_create_throws_repository_exception_if_type_is_tax_but_rate_not_provided()
  {
    $this->expectException(RepositoryException::class);
    $this->expectExceptionMessage('Rate should be provided for the tax type definition.');
    $repo = $this->getSut();
    $repo->create('Input GST 12%', 'Tax');
  }

  public function test_create_creates_definition_with_rate()
  {
    $repo = $this->getSut();
    $repo->create('Input GST 5%', 'Tax', 2.5);
    $this->assertDatabaseHas('ledger_definitions', ['name' => 'Input GST 5%', 'type' => 'Tax', 'rate' => 2.5]);
  }
}
