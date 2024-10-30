<?php
/**
 * Plugin Name: iFeed For Elementor
 * Description: iFeed For Elementor is a free plugin to display your Instagram posts. This plugin works with Elementor page builder. Furthermore, you can display the feed from your Instagram account in different layouts that come with this plugin. 
 * Plugin URI: https://www.wpconcern.com/downloads/ifeed-for-elementor/
 * Version: 1.0.6
 * Author: wpconcern
 * Author URI: https://www.wpconcern.com/
 * Text Domain: ifeed-for-elementor
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Instagram Feed For Elementor Class
 *
 * The init class that runs the Instagram Feed plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 * @since 1.2.0
 */
final class Ifeed_For_Elementor {

	/**
	 * Plugin Version
	 *
	 * @since 1.2.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.6';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.2.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.4.0';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Load translation
		add_action( 'init', array( $this, 'i18n' ) );

		// Init Plugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );

		//add admin page
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		add_action( 'admin_init', array( $this, 'register_setting' ) );

		if ( is_admin() ) {
		    add_action( 'admin_head', array( $this, 'ifeed_for_elementor_hook_admin_head' ) );
		}
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'ifeed-for-elementor' );
	}

	/**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'plugin.php' );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'ifeed-for-elementor' ),
			'<strong>' . esc_html__( 'iFeed For Elementor', 'ifeed-for-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'ifeed-for-elementor' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'ifeed-for-elementor' ),
			'<strong>' . esc_html__( 'iFeed For Elementor', 'ifeed-for-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'ifeed-for-elementor' ) . '</strong>',
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
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'ifeed-for-elementor' ),
			'<strong>' . esc_html__( 'iFeed For Elementor', 'ifeed-for-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'ifeed-for-elementor' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	///
	function admin_menu() {
		add_menu_page( 
	        __( 'iFeed For Elementor', 'ifeed-for-elementor' ),
	        __( 'iFeed For Elementor', 'ifeed-for-elementor' ),
	        'manage_options',
	        'ifeed-for-elementor',
	        array( $this, 'custom_menu_page' ),
	        plugins_url( 'ifeed-for-elementor/assets/img/insta-icon.png' ),
	        '966.1234'
	    );

	}

	function custom_menu_page(){

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'ifeed-for-elementor' ) );
		}

		require plugin_dir_path( __FILE__ ) . 'options.php';
	}

	function register_setting(){

		$args = array(
			'sanitize_callback' => array( $this, 'sanitization' )
		);

		register_setting( 'iffe_option_group', 'iffe_options', $args );

	}

	function sanitization( $data ){
		$data['username'] 		= sanitize_text_field( $data['username'] );
		$data['access_token'] 	= sanitize_text_field( $data['access_token'] );
		return $data;
	}

	function ifeed_for_elementor_hook_admin_head() {

	    wp_enqueue_style('ifeed-for-elementor-admin', plugins_url('/assets/css/admin-style.css', __FILE__) );            

	}
}

// Instantiate Ifeed_For_Elementor.
new Ifeed_For_Elementor();