<?php

namespace App\Http\Resources;

use App\Models\BabySitterInvitation;
use Illuminate\Http\Resources\Json\JsonResource;

class BabySitterUserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'photo' => $this->photo,
            'type' => $this->type,
            'can_rate' => $this->canRate(),
            'rate' => $this->rate,
            'birth_date' => $this->birth_date,
            'creator_id' => $this->creator_id,
            'creator_type' => $this->creator_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    private function canRate()
    {
        $invitations = BabySitterInvitation::query()
            ->where('parent_id', auth()->id())
            ->where('baby_sitter_id', $this->id)
            ->whereNotNull('accepted_at')
            ->get();
        return $invitations->count() > 0;
    }
}
