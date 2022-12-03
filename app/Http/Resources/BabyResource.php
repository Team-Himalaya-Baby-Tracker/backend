<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Baby */
class BabyResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'photo' => $this->photo,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'creator_id' => $this->creator_id,
            'creator_type' => $this->creator_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'baby_weight_histories' => BabyWeightHistoryResource::collection($this->whenLoaded('babyWeightHistories')),
            'baby_size_histories' => BabySizeHistoryResource::collection($this->whenLoaded('babySizeHistories')),
            'diaper_data' => DiaperDataResource::collection($this->whenLoaded('diaperData')),
            'breast_feed_records' => BreastFeedRecordResource::collection($this->whenLoaded('breastFeedRecords')),
            'parent' => new ParentUserResource($this->whenLoaded('parent')),
        ];
    }
}
