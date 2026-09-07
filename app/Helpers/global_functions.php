<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// db wp-fluent helper functions
if (!function_exists('atcfe_query')) {
    function atcfe_query()
    {
        if (!function_exists('atcfe_db')) {
            include ATC_PLUGIN_DIR_PATH . 'app/Libs/wp-fluent/wp-fluent.php';
        }
       
        return atcfe_db();
    }
}