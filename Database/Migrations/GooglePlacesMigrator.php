<?php

namespace ATC\Database\Migrations;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class GooglePlacesMigrator {

    public static $tableName = 'atcfe_google_places';
    
    public static function migrate() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        $table = $wpdb->prefix . static::$tableName;

        dbDelta(
            "CREATE TABLE {$table} (
                id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                place_id VARCHAR(255) NOT NULL,
                name VARCHAR(255) NULL,
                address TEXT NULL,
                rating DECIMAL(2,1) NULL,
                total_reviews INT UNSIGNED NULL,
                auto_fetch TINYINT(1) NOT NULL DEFAULT 0,
                download_method VARCHAR(50) NULL,
                created_at DATETIME NULL,
                updated_at DATETIME NULL,
                PRIMARY KEY (id),
                UNIQUE KEY unique_place_id (place_id)
            ) ENGINE=InnoDB {$charset_collate};"
        );
    }
}