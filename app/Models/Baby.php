<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baby extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(ParentUser::class, 'parent_id');
    }

    public function babySizeHistories()
    {
        return $this->hasMany(BabySizeHistory::class);
    }

    public function babyWeightHistories()
    {
        return $this->hasMany(BabyWeightHistory::class);
    }

    public function diaperData()
    {
        return $this->hasMany(DiaperData::class);
    }

    public function belongsToUser(User $user):bool
    {
        return $this->parent->id === $user->id ||  $this->parent->partener_id === $user->id;
    }
}
