<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BabySitterInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'baby_id',
        'baby_sitter_id',
        'expires_at',
        'accepted_at',
        'declined_at',
    ];


    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }

    public function babySitter()
    {
        return $this->belongsTo(User::class, 'baby_sitter_id');
    }

    public function scopeAccepted($query)
    {
        return $query->whereNotNull('accepted_at');
    }


    public function scopeDeclined($query)
    {
        return $query->whereNotNull('declined_at');
    }

    public function scopePending($query)
    {
        return $query->whereNull('accepted_at')->whereNull('declined_at');
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }


    public function scopeNotExpired($query)
    {
        return $query->where('expires_at', '>=', now());
    }

    public function scopeNotDeclined($query)
    {
        return $query->whereNull('declined_at');
    }

    public function scopeNotAccepted($query)
    {
        return $query->whereNull('accepted_at');
    }

    public function accept()
    {
        $this->update([
            'accepted_at' => now(),
        ]);
    }

    public function decline()
    {
        $this->update([
            'declined_at' => now(),
        ]);
    }


}
