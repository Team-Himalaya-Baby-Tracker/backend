<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerInvitation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invited()
    {
        return $this->belongsTo(ParentUser::class, 'invited_id');
    }

    public function inviter()
    {
        return $this->belongsTo(ParentUser::class, 'inviter_id');
    }

    public function accept()
    {
        $this->status = 'accepted';
        $this->save();
        $this->invited->partener_id = $this->inviter->id;
        $this->invited->save();
        $this->inviter->partener_id = $this->invited->id;
        $this->inviter->save();
    }

    public function decline()
    {
        $this->status = 'declined';
        $this->save();
    }
}
