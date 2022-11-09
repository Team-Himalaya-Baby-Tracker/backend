<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ParentUserResource;
use App\Http\Resources\UserResource;
use App\Models\ParentUser;
use Hash;

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

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $validated = $request->validated();

        //hash password
        if ($request->has('password')) {
            if(!Hash::check($request->input('current_password') , $user->password))
            {
                abort(400, "Invalid current password");
            }
            $validated['password'] = Hash::make($validated['password']);
            unset($validated['current_password']);
        }
        $user->update($validated);

        return new UserResource($user);
    }
}
