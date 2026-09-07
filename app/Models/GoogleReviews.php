<?php

namespace ATC\Models;

class GoogleReviews {

    protected $table = 'atcfe_google_reviews';

    public function getReviews() {
        $reviews = atcfe_query()->table($this->table)
                ->orderBy('id', 'ASC')
                ->get();

        return $reviews;
    }

    public function getReviewId($review_id) {
        $reviewId = atcfe_query()->table($this->table)->where('review_id', $review_id)->first();

        return $reviewId;
    } 


    public function getReviewsByPlaceId($place_id) {
        $reviews = atcfe_query()->table($this->table)->where('place_id', $place_id)->get();

        return $reviews;
    } 

    public function insertGetId($data) {
       
        $save = atcfe_query()->table($this->table)->insert($data);

        return $save;
    }

    public function deleteReviewsByPlaceId($place_id) {
        $delete = atcfe_query()->table($this->table)->where('place_id', $place_id)->delete();

        return $delete;
    }

    public function deleteReviewById($reviewId) {
        $delete = atcfe_query()->table($this->table)->where('id', $reviewId)->delete();

        return $delete;
    }
}