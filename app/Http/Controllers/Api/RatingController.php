<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use App\Models\Rating;
use App\Services\RatingService;
use App\Traits\apiResponseTrait;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    use apiResponseTrait;

    protected $ratingService;
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }
    /**
     * 
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created Rating.
     * @param StoreRatingRequest $request
     * @param Rating $rating
     * @return /Illuminate\Http\JsonResponse
     */
    public function store(StoreRatingRequest $request,Rating $rating)
    {
        $validatedData = $request->validated();
        $rating = $this->ratingService->addRating($validatedData,$rating);
        return $this->responseApi($rating,'you Created Rating Successfully',201);

    }

    /**
     * Display the specified rating.
     * 
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified rating.
     * @param UpdateRatingRequest $request
     * @param Rating $rating
     * @return /Illuminate\Http\JsonResponse 
     */
    public function update(UpdateRatingRequest $request, Rating $rating)
    {
        $validatedData = $request->validated();
        $ratingUpdated = $this->ratingService->updateRating($validatedData,$rating);
        return $this->responseApi($ratingUpdated,'You Update Rating Successfully',201);
    }

    /**
     * Remove the specified rating.
     * @param Rating $rating
     * @return /Illuminate\Http\JsonResponse 
     */
    public function destroy(Rating $rating)
    {
        $ratingDelete= $this->ratingService->deleteRating($rating);
        return $this->responseApi(null,null,204);

    }
}
