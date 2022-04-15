<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiaperDataStoreRequest;
use App\Http\Resources\DiaperDataResource;
use App\Models\Baby;
use Illuminate\Http\Request;

class DiaperDataController extends Controller
{
    public function index(Baby $baby)
    {
        return DiaperDataResource::collection($baby->diaperData);
    }

    public function store(DiaperDataStoreRequest $request, Baby $baby)
    {
        //todo:: validate baby belongs to user
        $diaperData = $baby->diaperData()->create($request->validated());

        return new DiaperDataResource($diaperData);
    }
}
