<?php

namespace ATC\Handlers;

use ATC\Database\DBMigrator;

class ActivationHandler
{
    public static function activate($network_wide)
    {
        require_once ATC_PLUGIN_DIR_PATH . 'Database/DBMigrator.php';

        DBMigrator::run($network_wide);

        if (!get_option('atc_google_reviews_api_key')){
            update_option('atc_google_reviews_api_key', [
                'api_key' => '',
            ]);
        }
    }
}