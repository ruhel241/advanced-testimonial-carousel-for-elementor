<?php

namespace ATC\Database\Migrations;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class GoogleReviewsMigrator {

    public static $tableName = 'atcfe_google_reviews';

    public static function migrate() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $table = $wpdb->prefix . static::$tableName;

        dbDelta(
            "CREATE TABLE {$table} (
                id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                place_id VARCHAR(255) NOT NULL,
                review_id VARCHAR(255) NOT NULL,
                author_name VARCHAR(255) NULL,
                author_photo TEXT NULL,
                rating DECIMAL(2,1) NULL,
                review_text TEXT NULL,
                review_time DATETIME NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL,
                PRIMARY KEY (id),
                UNIQUE KEY unique_place_review (place_id, review_id),
                KEY place_id (place_id)
            ) ENGINE=InnoDB {$charset_collate};"
        );
    }
}