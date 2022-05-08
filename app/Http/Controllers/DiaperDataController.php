<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiaperDataStoreRequest;
use App\Http\Resources\DiaperDataResource;
use App\Models\Baby;

class DiaperDataController extends Controller
{
    public function index(Baby $baby)
    {
        return DiaperDataResource::collection($baby->diaperData);
    }

    public function store(DiaperDataStoreRequest $request, Baby $baby)
    {
        abort_if(!$baby->belongsToUser(auth()->user()), 403, 'Baby does not belong to user');
        $diaperData = $baby->diaperData()->create($request->validated());

        return new DiaperDataResource($diaperData);
    }
}
