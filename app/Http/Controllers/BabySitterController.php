<?php

namespace App\Http\Controllers;

use App\Http\Resources\BabySitterInvitationResource;
use App\Http\Resources\BabySitterUserResource;
use App\Models\BabySitterInvitation;
use App\Models\BabySitterUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BabySitterController extends Controller
{
    public function index()
    {
        $babySitters = BabySitterUser::all();
        return BabySitterUserResource::collection($babySitters);
    }

    public function invite(Request $request)
    {
        $request->validate([
            'baby_id' => ['required', Rule::exists('babies', 'id')->where('parent_id', auth()->id())],
            'baby_sitter_id' => ['required', Rule::exists('users', 'id')->where('type', 'baby_sitter')],
            'expires_at' => ['required', 'date' , 'after:now'],
        ]);

        $invitation = BabySitterInvitation::where('baby_id', $request->baby_id)
            ->where('parent_id', auth()->id())
            ->where('baby_sitter_id', $request->baby_sitter_id)
            ->whereNull('declined_at')
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->first();
        abort_if($invitation, 400, 'Already invited');
        $babySitterInvitation = BabySitterInvitation::create([
            'parent_id' => auth()->id(),
            'baby_id' => $request->baby_id,
            'baby_sitter_id' => $request->baby_sitter_id,
            'expires_at' => $request->expires_at,
        ]);

        $babySitterInvitation->load('parent', 'baby', 'babySitter');
        return new BabySitterInvitationResource($babySitterInvitation);
    }

    public function listInvitations()
    {
        $invitations = BabySitterInvitation::query()
            ->with([
                'parent',
                'baby'=>fn($q) => $q->withoutGlobalScopes(),
            ])
            ->where('baby_sitter_id', auth()->id())
            ->whereNull('declined_at')
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->get();
        return BabySitterInvitationResource::collection($invitations);
    }

    public function respondToInvitation(BabySitterInvitation $invitation)
    {
        abort_if($invitation->baby_sitter_id != auth()->id(), 404);
        request()->validate([
            'accepted' => 'required|boolean',
        ]);
        if (request()->boolean('accepted')) {
            $invitation->accept();
        } else {
            $invitation->decline();
        }
        return BabySitterInvitationResource::make($invitation->load('parent', 'baby'));
    }

    public function terminate(BabySitterUser $babySitter)
    {
        $babySitter->babySitterInvitations()->where('parent_id', auth()->id())->delete();

        return response()->json(['message' => 'Terminated']);
    }
}
