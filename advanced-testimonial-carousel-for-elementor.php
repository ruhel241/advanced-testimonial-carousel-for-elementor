<?php
/**
 * Plugin Name: Advanced Testimonial Carousel For Elementor
 * Description: Advanced Testimonial Carousel for elementor wordpress plugin
 * Version:     3.0.4
 * Author:      wpcreativeidea
 * Author URI:  https://wpcreativeidea.com/home
 * Plugin URI:  https://wpcreativeidea.com/testimonial
 * License: GPLv2 or later
 * Text Domain: advanced-testimonial-carousel-for-elementor
 * Domain Path: /language
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Advanced Testimonial Carousel Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 3.0.4
 */

define('ATC_DIR_FILE', __FILE__);
define('ATC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ATC_LITE', 'advancedTestimonialLite');
define('ATC_PLUGIN_VERSION', '3.0.4');
define('ATC_PLUGIN_FILE_PATH', plugin_basename(__FILE__));

final class AdvancedTestimonialCarousel 
{

	/**
	 * Plugin Version
	 *
	 * @since 3.0.4
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '3.0.4';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 3.0.4
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 3.0.4
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 *
	 * @since 3.0.4
	 *
	 * @access private
	 * @static
	 *
	 * @var AdvancedTestimonialCarousel 
	 * The single instance of the class.
	 */
	private static $_instance = null;

    /**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 3.0.4
	 *
	 * @access public
	 * @static
	 *
	 * @return AdvancedTestimonialCarousel 
	 * An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 3.0.4
	 *
	 * @access public
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 3.0.4
	 *
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'advanced-testimonial-carousel-for-elementor' );
	}

	/**
	 * On Plugins Loaded
	 *
	 * Checks if Elementor has loaded, and performs some compatibility checks.
	 * If All checks pass, inits the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 3.0.4
	 *
	 * @access public
	 */
	public function on_plugins_loaded() {

		if (! did_action( 'elementor/loaded' ) ) {
			return $this->injectDependency();
		}

		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );

			if (defined('ATCPRO_DIR_FILE')) {
				if (!class_exists(ATCPRO\Services\ATCWidgetPro::class)) {
					require_once(ATCPRO_DIR_PATH.'Services/slider-widget.php');
				}
			}
		}
	}


	 /**
     * Notify the user about the Advanced Pricing Table dependency and instructs to install it.
     */
    protected function injectDependency()
    {
        add_action('admin_notices', function () {
            $pluginInfo = $this->getInstallationDetails();

            $class = 'notice notice-error';

            $install_url_text = 'Click Here to Install the Plugin';

            if ($pluginInfo->action == 'activate') {
                $install_url_text = 'Click Here to Activate the Plugin';
            }

			
            $message = 'Advanced Testimonial Carousel For Elementor Add-On Requires Elementor Base Plugin, <b><a href="' . $pluginInfo->url
                . '">' . $install_url_text . '</a></b>';

            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), wp_kses_post($message));
        });
    }

    /**
     * Get the Advanced Pricing Table plugin installation information e.g. the URL to install.
     *
     * @return \stdClass $activation
     */
    protected function getInstallationDetails()
    {
        $activation = (object)[
            'action' => 'install',
            'url'    => ''
        ];

        $allPlugins = get_plugins();

        if (isset($allPlugins['elementor/elementor.php'])) {
            $url = wp_nonce_url(
                self_admin_url('plugins.php?action=activate&plugin=elementor/elementor.php'),
                'activate-plugin_elementor/elementor.php'
            );
            
            $activation->action = 'activate';
        } else {
            $api = (object)[
                'slug' => 'elementor'
            ];

            $url = wp_nonce_url(
                self_admin_url('update.php?action=install-plugin&plugin=' . $api->slug),
                'install-plugin_' . $api->slug
            );
        }

        $activation->url = $url;

        return $activation;
    }
	

	public function atcPluginAction($links) {

        $newLink = [
            '<a href="'.admin_url('admin.php?page=elementor-settings#tab-atc-settings').'">' .esc_html__('Settings', 'advanced-testimonial-carousel-for-elementor'). '</a>'
        ];

		if (!defined('ATCPRO')) {
            $goPro = wp_kses_post('<a href="https://wpcreativeidea.com/testimonial" class="atc-go-pro" target="_blank" style="color:#39b54a;font-weight:bold;">' .esc_html__('Go Pro', 'advanced-testimonial-carousel-for-elementor'). '</a>');
            array_push($newLink, $goPro);
        }

        return array_merge($links, $newLink);
    }

	/**
	 * Compatibility Checks
	 *
	 * Checks if the installed version of Elementor meets the plugin's minimum requirement.
	 * Checks if the installed PHP version meets the plugin's minimum requirement.
	 *
	 * @since 3.0.4
	 *
	 * @access public
	 */
	public function is_compatible() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		return true;
	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 3.0.4
	 *
	 * @access public
	 */
	public function init() {
		
		include('load.php');
	
		$this->loadTextDomain();

		if ( is_admin() ) {
			$this->adminHooks();
		}

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		
		add_action('elementor/frontend/after_enqueue_styles', function() {
			wp_enqueue_style( 'atc-swiper-css', plugin_dir_url( __FILE__ ). 'assets/css/atc-testimonial.css', array(), ATC_PLUGIN_VERSION);
		});
		
		add_filter( 'plugin_action_links_'.ATC_PLUGIN_FILE_PATH, [$this, 'atcPluginAction'], 10, 1 );

		add_action('elementor/editor/after_enqueue_styles', function() {
			wp_enqueue_style( 'atc-editor-css', plugin_dir_url( __FILE__ ). 'assets/css/atc-editor.css', array(), ATC_PLUGIN_VERSION);
		});

		// after_enqueue_scripts
		add_action('elementor/frontend/after_enqueue_scripts', function() {
			wp_enqueue_script( 'atc-swiper-js', plugin_dir_url( __FILE__ ). 'assets/js/atc-testimonial.js', array('jquery'), ATC_PLUGIN_VERSION, true);
			
			wp_localize_script('atc-swiper-js', 'atcSwiperVar', array(
                'has_pro' => defined('ATCPRO')
            ));
		});
	}


	public function adminHooks(){

		add_action( 'admin_enqueue_scripts', array($this, 'enqueueScripts') );
		
		if (defined('ATCPRO')) {
			add_action('wp_ajax_atc_pro_lincese_ajax_actions', function() {
				$licenseController = new ATCPRO\Classes\LicenseController();
				$licenseController->handleAjaxCalls();
			});
		}
		
		add_action('wp_ajax_atc_pro_setup_addons', function() {
			$setupController = new ATC\Classes\SetupController();
			$setupController->handleAjaxCalls();
		});

	    if (defined('ELEMENTOR_VERSION')) {
			add_action('admin_init', [new ATC\Classes\AdminPageHandler(), 'initialLoad']);
		}

		add_action( 'admin_notices', [$this, 'atc_admin_Notice'] );
		add_action( 'admin_init', [$this,  'atc_notice_dismissed'] );
	}

	public function atc_admin_Notice() {
		
		$screen  = get_current_screen();
		$user_id = get_current_user_id();
		$nonce   = wp_create_nonce('atc_dismiss_notice_nonce');

		if (!get_user_meta( $user_id, 'atc-notice-dismissed', true )) {
			add_user_meta($user_id, 'atc-notice-dismissed', 'active');
		}
		
		if ( $screen->id == 'dashboard' ||  $screen->id == 'plugins' ) {
			if ( get_user_meta( $user_id, 'atc-notice-dismissed', true ) == 'active' ) { 
				?>
					<div class="notice notice-success is-dismissible" id="is_atcReviewNotice">
						<p>
							<?php esc_html_e('Congratulations! you have installed "Advanced Testimonial Carousel" for elementor plugin, Please rating this plugin.', 'advanced-testimonial-carousel-for-elementor'); ?>
							<em><a href="https://wordpress.org/support/plugin/advanced-testimonial-carousel-for-elementor/reviews/#new-post" target="_blank">Rating</a></em>
						</p>
						<a href="?atc-dismissed-notice=1&_atc_nonce=<?php echo esc_attr($nonce); ?>" type="button" class="notice-dismiss"></a>
					</div>
				<?php
			}
		}
	}

	public function atc_notice_dismissed() {
		$user_id = get_current_user_id();
	
		if (isset($_GET['atc-dismissed-notice']) && isset($_GET['_atc_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash ($_GET['_atc_nonce'], 'atc_dismiss_notice_nonce')) )) {
			update_user_meta($user_id, 'atc-notice-dismissed', 'deactive');
		}
			
	}

	public static function enqueueScripts()
    {
		wp_enqueue_style( 'atc-admin-css', ATC_PLUGIN_URL.'assets/css/atc-admin.css', array(), ATC_PLUGIN_VERSION);
		wp_enqueue_script( 'atc-admin-js', ATC_PLUGIN_URL.'assets/js/atc-admin.js', array('jquery'), ATC_PLUGIN_VERSION, true);
        wp_localize_script('atc-admin-js', 'atcProVar', [
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'has_pro' => defined('ATCPRO'),
			'nonce' => wp_create_nonce('atc_nonce')
		]);
    }

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 3.0.4
	 *
	 * @access public
	 */
	public function init_widgets() {

		// Include Widget files
		require_once( __DIR__ . '/widgets/atc-testimonial-widget.php' );

		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ATC\Classes\Widgets\ATCTestimonialWidget() );
	}

	public function loadTextDomain()
    {
        load_plugin_textdomain('advanced-testimonial-carousel-for-elementor', false, basename(dirname(__FILE__)) . '/languages');
	}
	
	
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 3.0.4
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset($_GET['activate']) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'advanced-testimonial-carousel-for-elementor' ),
			'<strong>' . esc_html__( 'Advanced Testimonial Carousel', 'advanced-testimonial-carousel-for-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'advanced-testimonial-carousel-for-elementor' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post($message) );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 3.0.4
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset($_GET['activate']) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'advanced-testimonial-carousel-for-elementor' ),
			'<strong>' . esc_html__( 'Advanced Testimonial Carousel', 'advanced-testimonial-carousel-for-elementor' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post($message) );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 3.0.4
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset($_GET['activate']) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'advanced-testimonial-carousel-for-elementor' ),
			'<strong>' . esc_html__( 'Advanced Testimonial Carousel', 'advanced-testimonial-carousel-for-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'advanced-testimonial-carousel-for-elementor' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post($message) );

	}
}

AdvancedTestimonialCarousel::instance();

function atcDeactivatePlugin() {
	$user_id = get_current_user_id();
	update_user_meta($user_id, 'atc-notice-dismissed', 'active');
}
register_deactivation_hook( __FILE__, 'atcDeactivatePlugin' );