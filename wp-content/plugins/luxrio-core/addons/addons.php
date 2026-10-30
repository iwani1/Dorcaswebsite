<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Luxrio Core Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Luxrio_Extension {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elementor_Test_Extension The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Test_Extension An instance of the class.
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
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );


		  //Defined Constants
		  if (!defined('LUXRIO_BADGE')) {
            define('LUXRIO_BADGE', '<span class="luxrio-core-badge"></span>');
        }

	}


	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Add Plugin actions
		add_action( 'elementor/widgets/register', [ $this, 'init_widgets' ] );

        // Register widget scripts
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'widget_scripts' ]);

		// Register Editor scripts
		add_action( 'elementor/editor/after_enqueue_scripts', [$this, 'editor_scripts'], 100 );

        // category register
		add_action( 'elementor/elements/categories_registered',[ $this, 'luxrio_elementor_widget_categories' ] );


		

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'luxrio' ),
			'<strong>' . esc_html__( 'Luxrio Core', 'luxrio' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'luxrio' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'luxrio' ),
			'<strong>' . esc_html__( 'Luxrio Core', 'luxrio' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'luxrio' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'luxrio' ),
			'<strong>' . esc_html__( 'Luxrio Core', 'luxrio' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'luxrio' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {

		$widgets_manager = \Elementor\Plugin::instance()->widgets_manager;


		// Header Elements
		require_once( LUXRIO_ADDONS . '/header/luxrio-header-menu.php' );
		require_once( LUXRIO_ADDONS . '/header/luxrio-search.php' );
		require_once( LUXRIO_ADDONS . '/header/luxrio-mobile-menu.php' );
		require_once( LUXRIO_ADDONS . '/header/luxrio-offcanvas.php' );
		require_once( LUXRIO_ADDONS . '/header/luxrio-logo.php' );
		require_once( LUXRIO_ADDONS . '/header/luxrio-megamenu-shortcode.php' );
		// require_once( LUXRIO_ADDONS . '/header/luxrio-minicart.php' );
		require_once( LUXRIO_ADDONS . '/header/luxrio-category-menu.php' );
 
		// // Footer Elements
		require_once( LUXRIO_ADDONS . '/footer-widgets/luxrio-menu-list.php' );

   
		// genarel widget
		require_once( LUXRIO_ADDONS . '/widgets/section-title.php' );
		require_once( LUXRIO_ADDONS . '/widgets/blog-post.php' );
		require_once( LUXRIO_ADDONS . '/widgets/button.php' );
		require_once( LUXRIO_ADDONS . '/widgets/luxrio-testimonial-slider.php' );
		require_once( LUXRIO_ADDONS . '/widgets/image-box/image-box.php' );
		require_once( LUXRIO_ADDONS . '/widgets/faq.php' );
		require_once( LUXRIO_ADDONS . '/widgets/luxrio-product-slider.php' );
		require_once( LUXRIO_ADDONS . '/widgets/luxrio-product-category.php' );
		require_once( LUXRIO_ADDONS . '/widgets/luxrio-product-grid.php' );
		require_once( LUXRIO_ADDONS . '/widgets/luxrio-offer-box.php' );
		require_once( LUXRIO_ADDONS . '/widgets/luxrio-instagram-slider.php' );
		require_once( LUXRIO_ADDONS . '/widgets/luxrio-view-card.php' );
		require_once( LUXRIO_ADDONS . '/widgets/luxrio-product-tab.php' );
		require_once( LUXRIO_ADDONS . '/widgets/luxrio-countdown.php' );
		require_once( LUXRIO_ADDONS . '/widgets/luxrio-product-banner.php' );
		require_once( LUXRIO_ADDONS . '/widgets/luxrio-product-category-tab.php' );
		require_once( LUXRIO_ADDONS . '/widgets/luxrio-product-category-slider.php' );
		require_once( LUXRIO_ADDONS . '/widgets/luxrio-testimonial-two.php' );
		require_once( LUXRIO_ADDONS . '/widgets/luxrio-product-slider-arrow.php' );


		// Sliders
		require_once( LUXRIO_ADDONS . '/widgets/hero-slider/slider-one.php' );
		require_once( LUXRIO_ADDONS . '/widgets/hero-slider/slider-two.php' );
		require_once( LUXRIO_ADDONS . '/widgets/hero-slider/slider-three.php' );
		require_once( LUXRIO_ADDONS . '/widgets/hero-slider/slider-four.php' );
		


		// Common Widget
		require_once( LUXRIO_ADDONS . '/widgets/luxrio-list-icon.php' );
	}

    public function widget_scripts() {
        wp_enqueue_script(
            'luxrio-frontend-script',
            LUXRIO_PLUGDIRURI . 'assets/js/luxrio-frontend.js',
            array('jquery'),
            false,
            true
		);
		wp_enqueue_style( 
            'luxrio-widget-style',
            LUXRIO_PLUGDIRURI . 'assets/css/style.css',
			microtime()
		);

		wp_enqueue_style( 
            'luxrio-addon-style',
            LUXRIO_PLUGDIRURI . 'assets/css/addons.css',
			microtime()
		);
	}
	public function editor_scripts() {
		wp_enqueue_style(
            'luxrio-editor-style',
            LUXRIO_PLUGDIRURI . 'assets/css/editor.css',
			microtime()
		);

		wp_enqueue_script(
            'luxrio-core-editor',
            LUXRIO_PLUGDIRURI . 'assets/js/editor.js',
			array('jquery'),
			microtime(),
			true
		);
    }


    function luxrio_elementor_widget_categories( $elements_manager ) {
        $elements_manager->add_category(
            'luxrio',
            [
                'title' => __( 'Luxrio', 'luxrio' ),
                'icon' 	=> 'fa fa-plug',
            ]
        );
        $elements_manager->add_category(
            'luxrio_footer_elements',
            [
                'title' => __( 'Luxrio Footer Elements', 'luxrio' ),
                'icon' 	=> 'fa fa-plug',
            ]
		);
		$elements_manager->add_category(
            'luxrio_header_elements',
            [
                'title' => __( 'Luxrio Header Elements', 'luxrio' ),
                'icon' 	=> 'fa fa-plug',
            ]
        );

	}

}
Luxrio_Extension::instance();