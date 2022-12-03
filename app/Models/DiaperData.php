<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaperData extends Model
{
    use HasFactory;

    protected $casts = ['type' => 'array'];
    protected $fillable = ['type', 'time', 'creator_id', 'creator_type'];
    protected $guarded = [];

    public function creator()
    {
        return $this->morphTo();
    }

}
