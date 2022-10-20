<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baby extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope('parent', function ($builder) {
            if (auth()->user()->type == 'parent') {
                $builder->where('parent_id', auth()->user()->id)
                ->orWhere('parent_id', auth()->user()->partener_id);
            }

            if (auth()->user()->type == 'baby_sitter') {
                $babies = BabySitterInvitation::where('baby_sitter_id', auth()->id())
                    ->whereNotNull('accepted_at')
                    ->whereNull('declined_at')
                    ->where('expires_at', '>', now())
                    ->get()
                    ->pluck('baby_id')
                    ->toArray();
                $builder->whereIn('id', $babies);
            }
        });
    }

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

    public function breastFeedRecords()
    {
        return $this->hasMany(BreastFeedRecord::class);
    }

    public function bottleFeeds()
    {
        return $this->hasMany(BottleFeed::class);
    }

    public function belongsToUser(User $user): bool
    {
        return $this->parent->id === $user->id || $this->parent->partener_id === $user->id;
    }

    public function babySitters()
    {
        return $this->belongsToMany(BabySitterUser::class, 'baby_sitter_invitations', 'baby_id', 'baby_sitter_id')
            ->using(BabySitterInvitation::class)
            ->withPivot(['id', 'parent_id', 'expires_at', 'accepted_at', 'declined_at'])
            ->wherePivot('accepted_at', '!=', null)
            ->wherePivot('declined_at', '=', null)
            ->withTimestamps();
    }

    public function babySitterInvitations()
    {
        return $this->hasMany(BabySitterInvitation::class);
    }
}
