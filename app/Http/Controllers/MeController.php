<?php

namespace App\Http\Controllers;

use App\Http\Resources\ParentUserResource;
use App\Http\Resources\UserResource;
use App\Models\ParentUser;

class MeController extends Controller
{
    public function me()
    {
        if (auth()->user()->type === 'parent')
        {
            $parent = ParentUser::find(auth()->id())->load('partener');
            return new ParentUserResource($parent);

        }else
        return new UserResource(auth()->user());
    }
}
