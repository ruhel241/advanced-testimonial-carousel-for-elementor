<?php

namespace ATC\Handlers;

use Elementor\Settings;

class AdminPageHandler {

	public function initialLoad() {
		add_action(
			'elementor/admin/after_create_settings/' . Settings::PAGE_ID,
			[ $this, 'register_settings_fields' ],
			11
		);
	
		add_action( 'admin_enqueue_scripts', array($this, 'enqueueScripts') );
		add_action( 'admin_head', [ $this, 'normalize_settings_tab_hash' ], 0 );
	}

	public function normalize_settings_tab_hash() {
		if ( ! isset( $_GET['page'] ) || 'elementor-settings' !== $_GET['page'] ) {
			return;
		}

		?>
		<script>
			jQuery(function ($) {
				if (window.location.hash === '#/tab-atcfe-settings') {
					setTimeout(function () {
						$('#elementor-settings-tab-atcfe-settings').trigger('click');
					}, 500);
				}
			});
		</script>
		<?php
	}

	public function enqueueScripts()
	{
		wp_enqueue_style(
			'atc-admin-css',
			ATC_PLUGIN_URL . 'assets/css/atc-admin.css',
			[],
			ATC_PLUGIN_VERSION
		);

		wp_enqueue_script(
			'atc-admin-boot',
			ATC_PLUGIN_URL . 'assets/js/boot.js',
			['jquery'],
			ATC_PLUGIN_VERSION,
			true
		);

		wp_enqueue_script(
			'atc-admin-start',
			ATC_PLUGIN_URL . 'assets/js/start.js',
			['jquery', 'atc-admin-boot'],
			ATC_PLUGIN_VERSION,
			true
		);

		wp_enqueue_script(
			'atc-admin-js',
			ATC_PLUGIN_URL . 'assets/js/atc-admin.js',
			['jquery'],
			ATC_PLUGIN_VERSION,
			true
		);

		wp_localize_script(
			'atc-admin-js',
			'atcAdminVars',
			[
				'ajaxurl' 	  => admin_url('admin-ajax.php'),
				'assets_url'  => ATC_PLUGIN_URL.'assets/',	
				'has_pro' 	  => defined('ATCPRO'),
				'nonce'   	  => wp_create_nonce('atc_nonce'),
			]
		);
	}

   public function register_settings_fields( $settings ) {
		$settings->add_tab(
			'atcfe-settings',
			[
				'label' => esc_html__( 'ATC Settings', 'advanced-testimonial-carousel-for-elementor' ),
				'sections' => [
					'atc-plugins-section' => [
						// 'label' => esc_html__( 'Recommended Addons', 'advanced-testimonial-carousel-for-elementor' ),
						'callback' => function() {
							$this->renderPage();
						},
						'fields' => [],
					]
				],
			]
		);
	}


    public function renderPage()
    {
		
		?>
			<div id="atcfe_admin_wrap"></div>
			
		<?php
    }
}
