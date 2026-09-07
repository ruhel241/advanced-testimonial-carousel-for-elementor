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

        // // remove cron
        // wp_clear_scheduled_hook('swiftcm_cleanup_tmp_dir');

        // if (!class_exists('\SwiftCertificateManager\Hooks\Handlers\AvailableOptions')) {
        //     require_once SWIFTCM_PLUGIN_DIR_PATH . 'app/Hooks/Handlers/AvailableOptions.php';
        // }

        // $dirs = AvailableOptions::getDirStructure();

        // $folders = [
        //     $dirs['tempDir'],
        //     $dirs['pdfCacheDir'],
        //     $dirs['fontDir'],
        //     $dirs['certificatesDir'],
        // ];

        // // ✅ WordPress recommended way
        // global $wp_filesystem;

        // if (empty($wp_filesystem)) {
        //     require_once ABSPATH . 'wp-admin/includes/file.php';
        //     WP_Filesystem();
        // }

        // foreach ($folders as $folder) {
        //     $wp_filesystem->delete($folder, true);
        // }

        /**
         * Delete all tables and options (optional)
         */
        // static::dropTables();
    }

    // public static function dropTables()
    // {
    //     global $wpdb;
        
    //     // delete options all options
    //     delete_option('swiftcm_global_settings');
    //     delete_option('swiftcm_onboarding_info');
    //     delete_option('swiftcm_is_onboarded');
    //     delete_option('swiftcm_newsletters');

    //     // Disable foreign key checks temporarily
    //     $wpdb->query("SET FOREIGN_KEY_CHECKS = 0");

    //     // List all tables to be deleted
    //     $tables = [
    //         $wpdb->prefix . 'swiftcm_generates',
    //         $wpdb->prefix . 'swiftcm_payments',
    //         $wpdb->prefix . 'swiftcm_templates',
    //         $wpdb->prefix . SWIFTCM_UPLOAD_DIR
    //     ];

    //     // Drop each table
    //     foreach ($tables as $table) {
    //         // Format for DROP TABLE using string concatenation outside the query
    //         // This is the WordPress core pattern for handling table names
    //         $table_name = '`' . esc_sql($table) . '`';
    //         $wpdb->query("DROP TABLE IF EXISTS $table_name");
    //     }

    //     // Re-enable foreign key checks
    //     $wpdb->query("SET FOREIGN_KEY_CHECKS = 1");

    //     return true;
    // }
}
