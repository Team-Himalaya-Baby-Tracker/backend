<?php

namespace App\Http\Controllers;

use App\Http\Requests\BottleFeedStoreRequest;
use App\Http\Resources\BottleFeedResource;
use App\Models\Baby;

class BottleFeedController extends Controller
{
    public function index(Baby $baby)
    {
        return BottleFeedResource::collection($baby->bottleFeeds);
    }

    public function store(BottleFeedStoreRequest $request, Baby $baby)
    {
        $bottleFeedData = $baby->bottleFeeds()->create($request->validated());
        return new BottleFeedResource($bottleFeedData);
    }
}
