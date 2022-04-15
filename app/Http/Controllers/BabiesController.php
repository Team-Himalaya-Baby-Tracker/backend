<?php

namespace App\Http\Controllers;

use App\Http\Requests\Babies\BabyStoreRequest;
use App\Http\Requests\Babies\BabyUpdateRequest;
use App\Http\Resources\BabyResource;
use App\Models\Baby;
use App\Models\ParentUser;
use App\Services\UploadImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BabiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $parent = ParentUser::find(auth()->id())->load('partener');
        return BabyResource::collection($parent->babies()->with(['babySizeHistories', 'BabyWeightHistories'])->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BabyStoreRequest $request
     * @return BabyResource
     */
    public function store(BabyStoreRequest $request, UploadImage $uploadImage)
    {
        $validated = $request->validated();
        $validated['photo'] = $uploadImage->upload($request->file('photo'), env('S3_BUCKET'), 'baby-photos');
        $validated ['parent_id'] = auth()->id();
        $baby = Baby::create($validated);

        return new BabyResource($baby);
    }

    /**
     * Display the specified resource.
     *
     * @param Baby $baby
     * @return BabyResource
     */
    public function show(Baby $baby)
    {
        $baby->load(['babySizeHistories', 'BabyWeightHistories']);
        return new BabyResource($baby);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Baby $baby
     * @return Response
     */
    public function update(BabyUpdateRequest $request, Baby $baby)
    {
        $validated = $request->validated();
        if ($validated['photo'] ?? null) {
            $uploadImage = new UploadImage();
            $validated['photo'] = $uploadImage->upload($request->file('photo'), env('S3_BUCKET'), 'baby-photos');
        }
        $baby->update(array_filter($validated));
        return new BabyResource($baby);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Baby $baby
     * @return JsonResponse
     */
    public function destroy(Baby $baby)
    {
        $baby->delete();
        return response()->json(['message' => 'Baby deleted successfully']);
    }
}
