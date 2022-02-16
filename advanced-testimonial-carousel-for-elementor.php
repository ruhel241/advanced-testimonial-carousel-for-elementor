<?php
/**
 * Plugin Name: Advanced Testimonial Carousel for Elementor
 * Description: Advanced Testimonial Carousel for elementor wordpress plugin
 * Plugin URI:  https://github.com/ruhel241/advanced-testimonial-carousel
 * Version:     1.1.0
 * Author:      Md.Ruhel Khan
 * Author URI:  https://github.com/ruhel241/
 * Text Domain: atc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Advanced Testimonial Carousel Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.1.0
 */
final class AdvancedTestimonialCarousel 
{

	/**
	 * Plugin Version
	 *
	 * @since 1.1.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.1.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.1.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.1.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 *
	 * @since 1.1.0
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
	 * @since 1.1.0
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
	 * @since 1.1.0
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
	 * @since 1.1.0
	 *
	 * @access public
	 */
	public function i18n() {

		load_plugin_textdomain( 'atc' );
	}

	/**
	 * On Plugins Loaded
	 *
	 * Checks if Elementor has loaded, and performs some compatibility checks.
	 * If All checks pass, inits the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 */
	public function on_plugins_loaded() {

		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}

		add_action( 'admin_notices', [$this, 'atc_admin_Notice'] );

	}

	public function atc_admin_Notice() {
		//get the current screen
		$screen = get_current_screen();
		//Checks if settings updated 
		if ( $screen->id == 'dashboard' ||  $screen->id == 'plugins' ) {
			?>
				<div class="notice notice-success is-dismissible">
					<p>
						<?php _e('Congratulations! you have installed "Advanced Testimonial Carousel for Elementor" plugin, Please rating this plugin.', 'atc'); ?>
						<em><a href="https://wordpress.org/plugins/advanced-testimonial-carousel-for-elementor/" target="_blank">Rating</a></em>
					</p>
				</div>
			<?php
		}
	}
	
	/**
	 * Compatibility Checks
	 *
	 * Checks if the installed version of Elementor meets the plugin's minimum requirement.
	 * Checks if the installed PHP version meets the plugin's minimum requirement.
	 *
	 * @since 1.1.0
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
	 * @since 1.1.0
	 *
	 * @access public
	 */
	public function init() {
	
		$this->loadTextDomain();

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		
		add_action('elementor/frontend/after_enqueue_styles', function() {
			wp_enqueue_style( 'atc-swiper-css', plugin_dir_url( __FILE__ ). 'assets/css/atc-testimonial.css');
		});

		// after_enqueue_scripts
		add_action('elementor/frontend/after_enqueue_scripts', function() {
			wp_enqueue_script( 'atc-swiper-js', plugin_dir_url( __FILE__ ). 'assets/js/atc-testimonial.js', array('jquery'));
		});
	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.1.0
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
        load_plugin_textdomain('atc', false, basename(dirname(__FILE__)) . '/languages');
	}
	
	
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'atc' ),
			'<strong>' . esc_html__( 'Advanced Testimonial Carousel', 'atc' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'atc' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'atc' ),
			'<strong>' . esc_html__( 'Advanced Testimonial Carousel', 'atc' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'atc' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'atc' ),
			'<strong>' . esc_html__( 'Advanced Testimonial Carousel', 'atc' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'atc' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

}

AdvancedTestimonialCarousel::instance();