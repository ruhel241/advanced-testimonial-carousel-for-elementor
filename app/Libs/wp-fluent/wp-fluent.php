<?php 

defined('ABSPATH') or die;

// Autoload plugin.
require 'autoload.php';

if (! function_exists('atcfe_db')) {
    /**
     * @return \AdvancedTestimonialCarouselFluent\QueryBuilder\QueryBuilderHandler
     */
    function atcfe_db() {
        static $atcfe_db;

        if (! $atcfe_db) {
            global $wpdb;

            $connection = new AdvancedTestimonialCarouselFluent\Connection($wpdb, ['prefix' => $wpdb->prefix]);

            $atcfe_db = new \AdvancedTestimonialCarouselFluent\QueryBuilder\QueryBuilderHandler($connection);
        }

        return $atcfe_db;
    }
}