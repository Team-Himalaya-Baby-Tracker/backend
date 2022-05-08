<?php

namespace App\Http\Controllers;

use App\Http\Requests\BreastFeedRecordStoreRequest;
use App\Http\Resources\BreastFeedRecordResource;
use App\Models\Baby;

class BreastFeedRecordController extends Controller
{
    public function index(Baby $baby)
    {
        return BreastFeedRecordResource::collection($baby->breastFeedRecords);
    }

    public function store(BreastFeedRecordStoreRequest $request, Baby $baby)
    {
        $diaperData = $baby->breastFeedRecords()->create($request->validated());

        return new BreastFeedRecordResource($diaperData);
    }
}
