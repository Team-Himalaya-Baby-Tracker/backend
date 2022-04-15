<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\PartnerInvitation */
class PartnerInvitationResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'inviter_id' => $this->inviter_id,
            'invited_id' => $this->invited_id,

            'invited' => new ParentUserResource($this->whenLoaded('invited')),
            'inviter' => new ParentUserResource($this->whenLoaded('inviter')),
        ];
    }
}
