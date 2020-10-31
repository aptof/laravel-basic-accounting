<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depreciation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ledger()
    {
        return $this->belongsTo('App/Models/Ledger');
    }
}
