<?php

namespace App\Models;

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
}
