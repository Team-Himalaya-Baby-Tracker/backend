<?php

namespace App\Http\Controllers;

use App\Http\Resources\PartnerInvitationResource;
use App\Models\ParentUser;
use App\Models\PartnerInvitation;
use Auth;

class PartnerController extends Controller
{
    public function showSentInvitations()
    {
        $user = Auth::user()->toParentUser();
        ray()->queries();
        $invitations = $user->sentParentInvitations()
            ->with('invited')
            ->get();
        return PartnerInvitationResource::collection($invitations);
    }

    public function showReceivedInvitations()
    {
        $user = Auth::user()->toParentUser();
        ray()->queries();

        $invitations = $user->recivedParentInvitations()
            ->with('inviter')
            ->get();
        return PartnerInvitationResource::collection($invitations);
    }

    public function sendInvitation()
    {
        request()->validate([
            'email' => 'required|email',
        ]);

        $parent = ParentUser::whereEmail(request('email'))
            ->where('id', '!=', Auth::user()->id)
            ->firstOrFail();
        $user = auth()->user()->toParentUser();
        $invitation = $user->sendParentInvitation($parent);
        return new PartnerInvitationResource($invitation);
    }

    public function respondToInvitation(PartnerInvitation $invitation)
    {
        ray($invitation->invited_id, auth()->id())->queries();
        abort_if($invitation->invited_id != auth()->id(), 404);
        request()->validate([
            'accepted' => 'required|boolean',
        ]);
        if (request()->boolean('accepted')) {
            $invitation->accept();
        } else {
            $invitation->decline();
        }
        return (new MeController())->me();
    }
}
