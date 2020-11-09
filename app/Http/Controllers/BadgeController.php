<?php

namespace App\Http\Controllers;

use App\Http\Requests\BadgeRequest;
use App\Http\Resources\BadgeResource;
use App\Models\Badge;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(BadgeResource::collection(Badge::all()), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BadgeRequest $request
     * @return JsonResponse
     */
    public function store(BadgeRequest $request)
    {
        $data = $request->only(['name', 'description']);

        $badge = Badge::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        return response()->json(BadgeResource::make($badge), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Badge $badge
     * @return JsonResponse
     */
    public function show(Badge $badge)
    {
        return response()->json(BadgeResource::make($badge), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BadgeRequest $request
     * @param  Badge $badge
     * @return JsonResponse
     */
    public function update(BadgeRequest $request, Badge $badge)
    {
        $data = $request->only(['name', 'description']);

        $badge->name = $data['name'];
        $badge->description = $data['description'];
        $badge->save();

        return response()->json(BadgeResource::make($badge), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Badge $badge
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Badge $badge)
    {
        $badge->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
