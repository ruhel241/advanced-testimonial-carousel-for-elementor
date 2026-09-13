<?php

namespace ATC\Http\Controllers;
use ATC\Models\GooglePlaces;
use ATC\Models\GoogleReviews;


class GoogleReviewsSettingsController
{
    public function register() {
        add_action('wp_ajax_atc_google_reviews_settings_admin_ajax', array($this, 'ajaxRoutes'));
    }

    public function ajaxRoutes()
    {
         // 🔐 Nonce check (CSRF protection).
         if ( ! check_ajax_referer( 'atc_nonce', 'nonce', false ) ) {
            wp_send_json_error(
                [
                    'message' => __(
                        'Invalid nonce',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                ],
                403
            );
        }
    
        // Permission check.
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error(
                [
                    'message' => __(
                        'Unauthorized access',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                ],
                403
            );
        }
    
        $request = wp_unslash( $_REQUEST );
    
        $route = sanitize_key( $request['route'] ?? '' );
    
        $maps = array(
            'get_google_api_key'              => 'getGoogleApiKey',
            'save_google_api_key'             => 'saveGoogleApiKey',
            'verify_google_place'             => 'verifyGooglePlace', 
            'get_google_places'               => 'getGooglePlaces',
            'save_google_place'               => 'saveGooglePlace',
            'get_google_reviews_by_place_id'  => 'getReviewsByPlaceId',
            'maybe_delete_google_place'       => 'maybeDeleteGooglePlace',
            'maybe_delete_google_review'      => 'maybeDeleteGoogleReview'

        );
    
        if ( ! isset( $maps[ $route ] ) ) {
            wp_send_json_error(
                [
                    'message' => __(
                        'Invalid route',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                ],
                400
            );
        }
    
        do_action( 'aptfe_doing_ajax_google_reviews_settings_' . $route );
    
        // Request data sanitization handled in methods.
        $this->{$maps[ $route ]}( $request );
    
        do_action(
            'aptfe_admin_ajax_handler_google_reviews_settings_catch',
            $route
        );
    }


    public function getGoogleApiKey($request)
    {
        $configs = get_option('atc_google_reviews_api_key', []);
    
        wp_send_json_success(
            [
                'message' => __(
                    'Google reviews getApiKey retrieved successfully',
                    'advanced-testimonial-carousel-for-elementor'
                ),
                'configs' => $configs,
            ],
            200
        );
    }

    public function saveGoogleApiKey($request)
    {

        $configs = wp_unslash( $request['configs'] ?? [] );

        $apiKey  = sanitize_text_field( $request['configs']['api_key'] ?? '' );

        if (!$apiKey) {
            wp_send_json_error(
                [
                    'message' => __(
                        'API key is required',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                ],
                400
            );
        }

      
        update_option('atc_google_reviews_api_key', $configs);
    
        wp_send_json_success(
            [
                'message' => __(
                    'Google reviews API key saved successfully',
                    'advanced-testimonial-carousel-for-elementor'
                ),
                'configs' => $configs,
            ],
            200
        );
    }


    // verifyGooglePlace
    public function verifyGooglePlace( $request )
    {
        $place_id = sanitize_text_field(
            $request['place_id'] ?? ''
        );

        if ( empty( $place_id ) ) {
            wp_send_json_error(
                [
                    'message' => __(
                        'Place ID is required.',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                ],
                400
            );
        }

        $configs = wp_unslash( $request['configs'] ?? [] );

        /*
        * Fetch Google Place data.
        */
        // $result = $this->GooglePlaceDataByApi( $place_id );
        $result = $this->GooglePlaceDataByApi( $place_id, $configs['download_method'] ?? 'newest' );

        if ( empty( $result ) ) {
            wp_send_json_error(
                [
                    'message' => __(
                        'Invalid Google Place ID or unable to fetch place data.',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                ],
                400
            );
        }

        /*
        * Store verified Google Place data temporarily.
        */
        $cache_key = 'atc_verified_place_' .
            get_current_user_id() .
            '_' .
            md5( $place_id );

        set_transient(
            $cache_key,
            $result,
            10 * MINUTE_IN_SECONDS
        );

        /*
        * Return verified place summary to Vue.
        */
        wp_send_json_success(
            [
                'place' => [
                    'name'         => $result['name'] ?? '',
                    'address'      => $result['formatted_address'] ?? '',
                    'rating'       => $result['rating'] ?? null,
                    'review_count' => $result['user_ratings_total'] ?? 0,
                ],
            ],
            200
        );
    }

    // get google places 
    public function getGooglePlaces($request)
    {
        $GooglePlaces = new GooglePlaces();
        $getPlaces    = $GooglePlaces->getPlaces();  
        
        foreach ($getPlaces as $key => $getPlace) {
            $getPlace->human_created_at = human_time_diff(strtotime($getPlace->updated_at), time()) . ' ago';    
        }

        wp_send_json_success(
            [
                'message' => __(
                    'Google reviews Place ID retrieved successfully',
                    'advanced-testimonial-carousel-for-elementor'
                ),
                'places' => $getPlaces,
            ],
            200
        );
    }

    // save google place
    public function saveGooglePlace( $request )
    {
        $configs = wp_unslash( $request['configs'] ?? [] );

        $place_id = sanitize_text_field( $configs['place_id'] ?? '' );

        $auto_fetch = ! empty( $configs['auto_fetch'] ) ? 1 : 0;

        $download_method = sanitize_text_field( $configs['download_method'] ?? '' );

        $action_type = sanitize_text_field( $request['action_type'] ?? 'update' );

        if ( empty( $place_id ) ) {
            wp_send_json_error(
                [
                    'message' => __(
                        'Place ID is required',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                ],
                400
            );
        }

        $GooglePlaces = new GooglePlaces();
       
        /*
        * Save new place.
        */
        if ( 'new' === $action_type ) {
            /*
            * Get previously verified Google Place data.
            */
            $cache_key = 'atc_verified_place_' . get_current_user_id() . '_' .  md5( $place_id );

            $result = get_transient( $cache_key );

            if ( empty( $result ) ) {
                wp_send_json_error(
                    [
                        'message' => __(
                            'Please verify the Google Place before saving.',
                            'advanced-testimonial-carousel-for-elementor'
                        ),
                    ],
                    400
                );
            }

            /*
            * Check if place already exists.
            */
            if ( empty( $GooglePlaces->getPlaceId( $place_id ) ) ) {

                $place_data = [
                    'place_id'        => $place_id,
                    'name'            => $result['name'] ?? '',
                    'address'         => $result['formatted_address'] ?? '',
                    'rating'          => $result['rating'] ?? null,
                    'total_reviews'   => $result['user_ratings_total'] ?? null,
                    'auto_fetch'      => $auto_fetch,
                    'download_method' => $download_method,
                    'created_at'      => gmdate( 'Y-m-d H:i:s' ),
                    'updated_at'      => gmdate( 'Y-m-d H:i:s' ),
                ];

                $GooglePlaces->insertGetId( $place_data );
            }

            /*
            * Save reviews.
            */
            $this->saveGoogleReviews( $place_id, $result['reviews'] ?? [] );

            /*
            * Remove temporary verified data.
            */
            delete_transient( $cache_key );

            wp_send_json_success(
                [
                    'message' => __(
                        'Google reviews Place ID saved successfully',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                ],
                200
            );
        }

        /*
        * Update existing place.
        */
        if ( 'update' === $action_type ) {
            error_log(print_r($configs['download_method'], 1));
            /*
            * Fetch latest Google Place data.
            */
            // $result = $this->GooglePlaceDataByApi( $place_id );
            $result = $this->GooglePlaceDataByApi( $place_id, $configs['download_method'] ?? 'newest' );

            if ( empty( $result ) ) {
                wp_send_json_error(
                    [
                        'message' => __(
                            'Unable to fetch Google Place data.',
                            'advanced-testimonial-carousel-for-elementor'
                        ),
                    ],
                    400
                );
            }

            $place_data = [
                'name'            => $result['name'] ?? '',
                'address'         => $result['formatted_address'] ?? '',
                'rating'          => $result['rating'] ?? null,
                'total_reviews'   => $result['user_ratings_total'] ?? null,
                'download_method' => $download_method,
                'updated_at'      => gmdate( 'Y-m-d H:i:s' ),
            ];

            $GooglePlaces->update( $place_id, $place_data );

            /*
            * Save new reviews.
            */
            $this->saveGoogleReviews( $place_id, $result['reviews'] ?? [] );

            wp_send_json_success(
                [
                    'message' => __(
                        'Google reviews fetched successfully',
                        'advanced-testimonial-carousel-for-elementor'
                    )
                ],
                200
            );
        }
    }

    // fetch google place data by api
    // private function GooglePlaceDataByApi( $place_id ) {

    //     $api_settings = get_option('atc_google_reviews_api_key', []);

    //     $api_key = $api_settings['api_key'] ?? '';

    //     if ( empty( $api_key ) || empty( $place_id ) ) {
    //         return [];
    //     }

    //     $url = add_query_arg(
    //         [
    //             'place_id' => $place_id,
    //             'fields' => 'name,formatted_address,rating,reviews,user_ratings_total',
    //             'key'      => $api_key,
    //         ],
    //         'https://maps.googleapis.com/maps/api/place/details/json'
    //     );

    //     $response = wp_remote_get(
    //         $url,
    //         [
    //             'timeout' => 15,
    //         ]
    //     );

    //     if ( is_wp_error( $response ) ) {
    //         return [];
    //     }

    //     $body = json_decode(
    //         wp_remote_retrieve_body( $response ),
    //         true
    //     );

    //     if (
    //         empty( $body ) ||
    //         empty( $body['result'] )
    //     ) {
    //         return [];
    //     }

    //     return $body['result'];
    // }
    private function GooglePlaceDataByApi( $place_id, $download_method = 'newest' ) {

        $api_settings = get_option(
            'atc_google_reviews_api_key',
            []
        );

        $api_key = $api_settings['api_key'] ?? '';

        if ( empty( $api_key ) || empty( $place_id ) ) {
            return [];
        }

        $download_method = in_array(
            $download_method,
            [ 'most_relevant', 'newest' ],
            true
        ) ? $download_method : 'newest';

        $url = add_query_arg(
            [
                'place_id'     => $place_id,
                'fields'       => 'name,formatted_address,rating,reviews,user_ratings_total',
                'reviews_sort' => $download_method,
                'key'          => $api_key,
            ],
            'https://maps.googleapis.com/maps/api/place/details/json'
        );

        $response = wp_remote_get(
            $url,
            [
                'timeout' => 15,
            ]
        );

        if ( is_wp_error( $response ) ) {
            return [];
        }

        $body = json_decode(
            wp_remote_retrieve_body( $response ),
            true
        );

        if (
            empty( $body ) ||
            empty( $body['result'] )
        ) {
            return [];
        }

        return $body['result'];
    }

    // save google reviews
    private function saveGoogleReviews( $place_id, $reviews ) {

        if ( empty( $place_id ) || empty( $reviews ) ) {
            return;
        }

        $GoogleReviews = new GoogleReviews();

        foreach ( $reviews as $review ) {

            /*
            * Generate unique review ID.
            */
            $review_id = md5(
                $place_id .
                ( $review['author_url'] ?? '' ) .
                ( $review['time'] ?? '' ) .
                ( $review['text'] ?? '' )
            );

            /*
            * Skip if review already exists.
            */
            if ( ! empty( $GoogleReviews->getReviewId( $review_id ) ) ) {
                continue;
            }

            $review_data = [
                'place_id'     => $place_id,
                'review_id'    => $review_id,
                'author_name'  => $review['author_name'] ?? '',
                'author_photo' => $review['profile_photo_url'] ?? '',
                'rating'       => $review['rating'] ?? null,
                'review_text'  => $review['text'] ?? '',
                'review_time'  => ! empty( $review['time'] ) ? gmdate( 'Y-m-d H:i:s', $review['time'] ) : null,
                'created_at'   => gmdate( 'Y-m-d H:i:s' ),
                'updated_at'   => gmdate( 'Y-m-d H:i:s' ),
            ];

            $GoogleReviews->insertGetId( $review_data );
        }
    }

    // get reviews by place id
    public function getReviewsByPlaceId($request)
    {
        $placeId = sanitize_text_field( $request['place_id'] ?? '' );

        if (!$placeId) {
            wp_send_json_error(
                [
                    'message' => __(
                        'Place ID is required',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                ],
                400
            );
        }

        $GooglePlaces  = new GooglePlaces();
        $GoogleReviews = new GoogleReviews();

        $getReviews  = $GoogleReviews->getReviewsByPlaceId($placeId); 
        $getPlace    = $GooglePlaces->getPlaceId($placeId);    

        wp_send_json_success(
            [
                'message' => __(
                    'Google reviews retrieved successfully',
                    'advanced-testimonial-carousel-for-elementor'
                ),
                'reviews' => $getReviews,
                'place'   => $getPlace
            ],
            200
        );
    }

    public function maybeDeleteGooglePlace($request)
    {
        $placeId = sanitize_text_field( $request['place_id'] ?? '' );

        if ( empty( $placeId ) ) {
            wp_send_json_error(
                [
                    'message' => __(
                        'Place ID is required',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                ],
                400
            );
        }

        $GooglePlaces = new GooglePlaces();
        $GoogleReviews = new GoogleReviews();

        // Delete reviews associated with the place.
        $GoogleReviews->deleteReviewsByPlaceId( $placeId );

        // Delete the place.
        $GooglePlaces->deletePlace( $placeId );

        wp_send_json_success(
            [
                'message' => __(
                    'Google place and its reviews deleted successfully',
                    'advanced-testimonial-carousel-for-elementor'
                ),
            ],
            200
        );     
    }

    public function maybeDeleteGoogleReview($request)
    {
        $reviewId = sanitize_text_field( $request['id'] ?? '' );

        if ( empty( $reviewId ) ) {
            wp_send_json_error(
                [
                    'message' => __(
                        'Review ID is required',
                        'advanced-testimonial-carousel-for-elementor'
                    ),
                ],
                400
            );
        }

        $GoogleReviews = new GoogleReviews();

        // Delete the review.
        $GoogleReviews->deleteReviewById( $reviewId );

        wp_send_json_success(
            [
                'message' => __(
                    'Google review deleted successfully',
                    'advanced-testimonial-carousel-for-elementor'
                ),
            ],
            200
        );
        
    }
}