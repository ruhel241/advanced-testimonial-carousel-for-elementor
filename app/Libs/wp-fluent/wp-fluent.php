<?php 

defined('ABSPATH') or die;

// Autoload plugin.
require 'autoload.php';

if (! function_exists('atc_db')) {
    /**
     * @return \AdvancedTestimonialCarouselFluent\QueryBuilder\QueryBuilderHandler
     */
    function atc_db() {
        static $atc_db;

        if (! $atc_db) {
            global $wpdb;

            $connection = new AdvancedTestimonialCarouselFluent\Connection($wpdb, ['prefix' => $wpdb->prefix]);

            $atc_db = new \AdvancedTestimonialCarouselFluent\QueryBuilder\QueryBuilderHandler($connection);
        }

        return $atc_db;
    }
}