<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BabySitterRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'baby_sitter_id',
        'parent_id',
        'rating',
    ];

    protected $table = 'baby_sitter_ratings';

    public function babySitter()
    {
        return $this->belongsTo(BabySitterUser::class, 'baby_sitter_id');
    }

    public function parent()
    {
        return $this->belongsTo(ParentUser::class, 'parent_id');
    }

}
