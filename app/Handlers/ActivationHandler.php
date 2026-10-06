<?php

namespace ATCFE\Handlers;

use ATCFE\Database\DBMigrator;

class ActivationHandler
{
    public static function activate($network_wide)
    {
        require_once ATCFE_PLUGIN_DIR_PATH . 'Database/DBMigrator.php';

        DBMigrator::run($network_wide);

        if (!get_option('atcfe_google_reviews_api_key')){
            update_option('atcfe_google_reviews_api_key', [
                'api_key' => '',
            ]);
        }
    }
}