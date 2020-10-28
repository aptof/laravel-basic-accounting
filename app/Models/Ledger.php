<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
  use HasFactory;

  protected $guarded = ['id'];

  public function definition()
  {
    return $this->belongsTo('App\Models\LedgerDefinition');
  }

  public function year()
  {
    return $this->belongsTo('App\Models\Year');
  }
}
