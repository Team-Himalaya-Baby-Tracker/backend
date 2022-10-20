<?php

namespace App\Http\Controllers;

use App\Http\Resources\BabySitterInvitationResource;
use App\Models\BabySitterInvitation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParentController extends Controller
{
    public function myBabySitterInvitations()
    {
        $invitations = BabySitterInvitation::with(['baby', 'babySitter'])->where('parent_id', auth()->user()->id)->get();
        return BabySitterInvitationResource::collection($invitations);
    }

    public function updateBabySitterInvitation(Request $request, BabySitterInvitation $invitation)
    {
        abort_if($invitation->parent_id != auth()->id(), 404);
        $request->validate([
            'expires_at' => ['nullable', 'date', 'after:now'],
            'baby_id' => ['nullable', Rule::exists('babies', 'id')->where('parent_id', auth()->id())],
        ]);

        $invitation->update($request->only(['expires_at', 'baby_id']));
        $invitation->load(['baby', 'babySitter']);
        return new BabySitterInvitationResource($invitation);
    }
}
