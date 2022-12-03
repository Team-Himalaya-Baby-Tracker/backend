<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\BabyWeightHistory */
class BabyWeightHistoryResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'baby_id' => $this->baby_id,
            'weight' => $this->weight,
            'creator_id' => $this->creator_id,
            'creator_type' => $this->creator_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
