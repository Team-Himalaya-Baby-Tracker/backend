<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BabyWeightHistory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function creator()
    {
        return $this->morphTo();
    }
}
