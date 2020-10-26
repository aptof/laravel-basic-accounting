<?php

namespace App\Repositories;

use Exception;

class RepositoryException extends Exception
{
  public function __construct($message = 'Repository exception is thrown')
  {
    parent::__construct($message);
  }
}
