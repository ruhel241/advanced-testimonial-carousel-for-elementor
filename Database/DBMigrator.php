<?php

namespace ATC\Database;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use ATC\Database\Migrations\GooglePlacesMigrator;
use ATC\Database\Migrations\GoogleReviewsMigrator;

class DBMigrator {

	public static function run( $network_wide = false ) {

		if ( $network_wide ) {

			$site_ids = get_sites(
				array(
					'fields'     => 'ids',
					'network_id' => get_current_network_id(),
				)
			);

			foreach ( $site_ids as $site_id ) {

				switch_to_blog( $site_id );

				static::migrate();

				restore_current_blog();
			}

		} else {

			static::migrate();

		}
	}

	private static function migrate() {

	
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		require_once ATC_PLUGIN_DIR_PATH . 'Database/Migrations/GooglePlacesMigrator.php';
		require_once ATC_PLUGIN_DIR_PATH . 'Database/Migrations/GoogleReviewsMigrator.php';
		
        GooglePlacesMigrator::migrate();
        GoogleReviewsMigrator::migrate();


		// require_once ATC_PLUGIN_DIR_PATH . 'Database/Migrations/GooglePlacesMigrator.php';

		// require_once ATC_PLUGIN_DIR_PATH . 'Database/Migrations/GoogleReviewsMigrator.php';

		// GooglePlacesMigrator::migrate();

		// GoogleReviewsMigrator::migrate();
	}
}