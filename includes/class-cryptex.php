<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * The main theme class.
 */
class Cryptex {

	/**
	 * The template directory URL.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $template_dir_url = '';

	/**
	 * The one, true instance of the Cryptex object.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 */
	public static $instance = null;

	/**
	 * The theme version.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $version = '1.0';

	/**
	 * Determine if we're currently upgrading/migration options.
	 *
	 * @static
	 * @access public
	 * @var bool
	 */
	public static $is_updating  = false;

	/**
	 * Bundled Plugins.
	 *
	 * @static
	 * @access public
	 * @var array
	 */
	public static $bundled_plugins = array();

	/**
	 * Knowhere_Product_registration
	 *
	 * @access public
	 * @var object Knowhere_Product_registration.
	 */
	public $registration;

	/**
	 * Access the single instance of this class.
	 *
	 * @return Cryptex
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new Cryptex();
		}
		return self::$instance;
	}

	/**
	 * The class constructor
	 */
	private function __construct() {

		// Initialize bundled plugins array.
		self::$bundled_plugins = array(
			'theme_functionality' => array( 'slug' => 'cryptox-theme-functionality', 'name' => esc_html__('Cryptox Theme - Functionality', 'cryptox'), 'source' => 'http://velikorodnov.com/wordpress/sample-data/cryptox/plugins18/cryptox-theme-functionality.zip', 'version' => '1.0.4' ),
			'composer' => array( 'slug' => 'js_composer', 'name' => esc_html__('WPBakery Page Builder', 'cryptox'), 'source' => 'http://velikorodnov.com/wordpress/sample-data/pluginusan/js_composer.zip', 'version' => '6.7.0' ),
			'easy_tables' => array( 'slug' => 'easy-tables-vc', 'name' => esc_html__('Easy Tables (vc)', 'cryptox'), 'version' => '2.0.1', 'source' => 'http://velikorodnov.com/wordpress/sample-data/cryptox/plugins18/easy-tables-vc.zip' ),
			'cryptocurrency' => array( 'slug' => 'virtual-coin-widgets', 'name' => esc_html__('Virtual Coin Widgets For Visual Composer', 'cryptox'), 'source' => 'http://velikorodnov.com/wordpress/sample-data/cryptox/plugins18/virtual_coin_widgets_vc.zip', 'version' => '2.2.2' ),
			'crypto' => array( 'slug' => 'ultimate-crypto-widgets', 'name' => esc_html__('Ultimate Crypto Widgets', 'cryptox'), 'source' => 'http://velikorodnov.com/wordpress/sample-data/cryptox/plugins18/ultimate_crypto_widgets.zip', 'version' => '1.3.8.1' ),
//			'wpml' => array( 'slug' => 'sitepress-multilingual-cms', 'name' => esc_html__('WPML Multilingual CMS', 'cryptox'), 'source' => 'http://velikorodnov.com/wordpress/sample-data/pluginus/sitepress-multilingual-cms.zip', 'version' => '4.0.2' ),
		);

	}

	/**
	 * Gets the theme version.
	 *
	 * @since 5.0
	 *
	 * @return string
	 */
	public static function get_theme_version() {
		return self::$version;
	}

	/**
	 * Gets the bundled plugins.
	 *
	 * @since 5.0
	 *
	 * @return array Array of bundled plugins.
	 */
	public static function get_bundled_plugins() {
		return self::$bundled_plugins;
	}

}