<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BabySitterInvitationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent' => new ParentUserResource($this->whenLoaded('parent')),
            'baby' => new BabyResource($this->whenLoaded('baby')),
            'baby_sitter' => new BabySitterUserResource($this->whenLoaded('babySitter')),
            'expires_at' => $this->expires_at,
            'accepted_at' => $this->accepted_at,
            'declined_at' => $this->declined_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

    }
}
