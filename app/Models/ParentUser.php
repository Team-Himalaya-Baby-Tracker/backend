<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParentUser extends Model
{
    protected $table = 'users';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('ancient', function (Builder $builder) {
            $builder->where('type', 'parent');
        });
    }

    public function partener(): BelongsTo
    {
        return $this->belongsTo(ParentUser::class, 'partener_id');
    }

    public function babiesRelation()
    {
        return $this->hasMany(Baby::class, 'parent_id');
    }

    public function babies()
    {
        return $this->babiesRelation()
            ->union(
                Baby::query()->where('parent_id', '=', $this->partener_id)
            );
    }

    public function recivedParentInvitations()
    {
        return $this->hasMany(PartnerInvitation::class, 'invited_id')->where('status' , 'pending');
    }

    public function sentParentInvitations()
    {
        return $this->hasMany(PartnerInvitation::class, 'inviter_id')->where('status' , 'pending');
    }

    public function sendParentInvitation(ParentUser $parentUser)
    {
      return  $this->sentParentInvitations()->create([
            'invited_id' => $parentUser->id,
            'status' => 'pending',
        ]);
    }
}
