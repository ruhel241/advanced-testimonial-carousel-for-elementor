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

    public function getGoogleReviews( $params )
    {
        $place_id  = sanitize_text_field( $params['place_id'] ?? '' );
        $rating    = $params['rating'] ?? '';  
        $sort      = $params['sort'] ?? ''; 
        $date_sort = $params['date_sort'] ?? ''; 
       
        $query = atcfe_query()
                ->table( $this->table )
                ->where( 'place_id', $place_id );

            // Specific rating selected.
            if (!empty($rating) ) {
                $query->where( 'rating', $rating );
            }

            // Sort by rating.
            if ( 'high_to_low' === $sort ) {
                $query->orderBy( 'rating', 'DESC' );
            } elseif ( 'low_to_high' === $sort ) {
                $query->orderBy( 'rating', 'ASC' );
            }

            // date sorting
            if ( 'recent' === $date_sort ) {
                $query->orderBy(  'review_time', 'DESC' );
            } elseif ( 'old' === $date_sort ) {
                $query->orderBy( 'review_time', 'ASC');
            }

            return $query->get();
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