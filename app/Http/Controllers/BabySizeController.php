<?php

namespace App\Http\Controllers;

use App\Http\Resources\BabySizeHistoryResource;
use App\Models\Baby;

class BabySizeController extends Controller
{
    public function index(Baby $baby)
    {
        return BabySizeHistoryResource::collection($baby->babySizeHistories);
    }

    public function store(Baby $baby)
    {
        abort_if(!$baby->belongsToUser(auth()->user()), 403 , 'You can not add a size history to this baby');
        $validatedData = request()->validate([
            'size' => 'required|numeric|min:0',
            'created_at' => 'nullable|date',
        ]);
        $validatedData = array_filter($validatedData);
        $size = $baby->babySizeHistories()->create($validatedData);
        return new BabySizeHistoryResource($size);
    }

}
