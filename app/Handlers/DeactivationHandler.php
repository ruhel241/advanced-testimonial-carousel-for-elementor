<?php

namespace ATC\Handlers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DeactivationHandler
{
    public static function deActivate($network_wide)
    {
        if (is_multisite()) {
            return;
        }

        // remove cron
        wp_clear_scheduled_hook('atc_auto_fetch_reviews');
    }
}
