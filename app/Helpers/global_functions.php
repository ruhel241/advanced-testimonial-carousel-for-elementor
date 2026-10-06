<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use ATCFE\Models\GooglePlaces;
use ATCFE\Http\Controllers\GoogleReviewsSettingsController;

if ( ! class_exists( GooglePlaces::class ) ) {
    require_once ATCFE_PLUGIN_DIR_PATH . 'app/Models/GooglePlaces.php';
}

if ( ! class_exists( GoogleReviewsSettingsController::class ) ) {
    require_once ATCFE_PLUGIN_DIR_PATH . 'app/Http/Controllers/GoogleReviewsSettingsController.php';
}

// db wp-fluent helper functions
if (!function_exists('atc_query')) {
    function atc_query() {
        if (!function_exists('atc_db')) {
            include ATCFE_PLUGIN_DIR_PATH . 'app/Libs/wp-fluent/wp-fluent.php';
        }
       
        return atc_db();
    }
}