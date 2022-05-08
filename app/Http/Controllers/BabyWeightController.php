<?php

namespace App\Http\Controllers;

use App\Http\Resources\BabyWeightHistoryResource;
use App\Models\Baby;

class BabyWeightController extends Controller
{
    public function index(Baby $baby)
    {
        return BabyWeightHistoryResource::collection($baby->babyWeightHistories);
    }

    public function store(Baby $baby)
    {
        $validatedData = request()->validate([
            'weight' => 'required|numeric|min:0',
            'created_at' => 'nullable|date',
        ]);
        $validatedData = array_filter($validatedData);
        $size = $baby->babyWeightHistories()->create($validatedData);
        return new BabyWeightHistoryResource($size);
    }
}
