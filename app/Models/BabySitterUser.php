<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BabySitterUser extends Model
{
    protected $table = 'users';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('user_type', function (Builder $builder) {
            $builder->where('type', 'baby_sitter');
        });
    }

    public function baby()
    {
        return $this->belongsToMany(Baby::class, 'baby_sitter_invitations', 'baby_sitter_id', 'baby_id')
                ->using(BabySitterInvitation::class)
                ->withPivot(['id', 'parent_id', 'expires_at', 'accepted_at', 'declined_at'])
                ->wherePivot('accepted_at', '!=', null)
                ->wherePivot('declined_at', '=', null)
                ->withTimestamps();
    }

    public function babySitterInvitations()
    {
        return $this->hasMany(BabySitterInvitation::class, 'baby_sitter_id');
    }

    public function rates()
    {
        return $this->hasMany(BabySitterRating::class, 'baby_sitter_id');
    }

    public function getRateAttribute()
    {
        return round($this->rates()->avg('rating'), 2);
    }
}
