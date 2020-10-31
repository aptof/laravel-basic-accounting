<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
  use HasFactory;

  protected $guarded = ['id'];

  public function year()
  {
    return $this->belongsTo('App\Models\Year');
  }

  public function transactions()
  {
    return $this->hasMany('App\Models\Transaction');
  }
}
