<?php

namespace App\Services;

use App\Models\Rating;
use App\Traits\apiResponseTrait;
use Exception;
use JsonException;

class RatingService{
    use apiResponseTrait;

    public function addRating(array $data,Rating $rating)
    {
        $user_id = auth()->user()->id;
        $rating = Rating::create([
            //i put this steatment because when i put data in postman it confirmed to string so i use casting to avoid this problem
            'book_id' => isset($data['book_id']) ? (int)$data['book_id'] : $rating->book_id,
            'user_id' => $user_id,
            //i put this steatment because when i put data in postman it confirmed to string so i use casting to avoid this problem
            'rating' => isset($data['rating']) ? (int)$data['rating'] : $rating->rating,
        ]);
        // Check if the rating was created successfully
        if(!$rating){
            return throw new Exception('Failed to created rating');
        }
        return $rating;
    }

    public function updateRating(array $data ,Rating $rating )
    {
        $userId = auth()->user()->id;
        //check the user if this rating is for him
        if ($rating->user_id !== auth()->user()->id) {
            return $this->responseApi( null,'You can not edit ,because this rating is not yours',400);
        }
        $ratingData = array_filter([
            //i put this steatment because when i put data in postman it confirmed to string so i use casting to avoid this problem
            'book_id' => isset($data['book_id']) ? (int)$data['book_id'] : $rating->book_id,
            'user_id' =>$userId,
            //i put this steatment because when i put data in postman it confirmed to string so i use casting to avoid this problem
            'rating' => isset($data['rating']) ? (int)$data['rating'] : $rating->rating,
        ]);
        $rating->update($ratingData);
        return $rating;
    }

    public function deleteRating(Rating $rating)
    {
        //check the user if this rating is for him
        if ($rating->user_id !== auth()->user()->id) {
            return $this->responseApi( null,'You can not delete ,because this rating is not yours',400);
        }
        $rating->delete();
        return $rating;
    }
}