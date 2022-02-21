<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Cryptex for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */

add_action( 'tgmpa_register', 'cryptex_register_required_plugins' );

if ( !function_exists('cryptex_added_admin_action') ) {

	function cryptex_added_admin_action() {
		add_action( 'admin_enqueue_scripts', 'cryptex_added_plugin_style' );
	}

	function cryptex_added_plugin_style() {
		wp_enqueue_style( 'cryptex-admin-plugins', get_theme_file_uri('css/admin-plugin.css'), array() );
	}

	add_action( 'load-plugins.php', 'cryptex_added_admin_action', 1 );

}
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function cryptex_register_required_plugins() {

	$bundled_plugins = Cryptex()->get_bundled_plugins();

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'     => 'Redux Framework',
			'slug'     => 'redux-framework',
			'required' => false
		),

		array(
			'name'     => 'Woocommerce',
			'slug'     => 'woocommerce',
			'required' => false
		),

		array(
			'name'     => 'The Events Calendar',
			'slug'     => 'the-events-calendar',
			'required' => false
		),

		array(
			'name'     => esc_html__('Contact Form 7', 'cryptox'),
			'slug'     => 'contact-form-7',
			'required' => false
		),

		array(
			'name' => esc_html__('MailPoet Newsletters', 'cryptox'),
			'slug' => 'wysija-newsletters',
			'required' => false
		),

		array(
			'name' => esc_html__('Latest Tweets Widget', 'cryptox'),
			'slug' => 'latest-tweets-widget',
			'required' => false
		),

		// This is an example of how to include a plugin from the WordPress Plugin Repository.

		array(
			'name'               => $bundled_plugins['theme_functionality']['name'],
			'slug'               => $bundled_plugins['theme_functionality']['slug'],
			'source'             => $bundled_plugins['theme_functionality']['source'],
			'required'           => false,
			'version'            => $bundled_plugins['theme_functionality']['version'],
			'force_activation'   => false,
			'force_deactivation' => false
		),

		array(
			'name'               => $bundled_plugins['easy_tables']['name'],
			'slug'               => $bundled_plugins['easy_tables']['slug'],
			'source'             => $bundled_plugins['easy_tables']['source'],
			'required'           => false,
			'version'            => $bundled_plugins['easy_tables']['version'],
			'force_activation'   => false,
			'force_deactivation' => false
		),

		array(
			'name'               => $bundled_plugins['composer']['name'],
			'slug'               => $bundled_plugins['composer']['slug'],
			'source'             => $bundled_plugins['composer']['source'],
			'required'           => false,
			'version'            => $bundled_plugins['composer']['version'],
			'force_activation'   => false,
			'force_deactivation' => false
		),

		array(
			'name'               => $bundled_plugins['cryptocurrency']['name'],
			'slug'               => $bundled_plugins['cryptocurrency']['slug'],
			'source'             => $bundled_plugins['cryptocurrency']['source'],
			'required'           => false,
			'version'            => $bundled_plugins['cryptocurrency']['version'],
			'force_activation'   => false,
			'force_deactivation' => false
		),

		array(
			'name'               => $bundled_plugins['crypto']['name'],
			'slug'               => $bundled_plugins['crypto']['slug'],
			'source'             => $bundled_plugins['crypto']['source'],
			'required'           => false,
			'version'            => $bundled_plugins['crypto']['version'],
			'force_activation'   => false,
			'force_deactivation' => false
		),

//		array(
//			'name'               => $bundled_plugins['wpml']['name'],
//			'slug'               => $bundled_plugins['wpml']['slug'],
//			'source'             => $bundled_plugins['wpml']['source'],
//			'required'           => false,
//			'version'            => $bundled_plugins['wpml']['version'],
//			'force_activation'   => false,
//			'force_deactivation' => false
//		)

	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       => 'cryptox', // Text domain - likely want to be the same as your theme.
		'id'           => 'cryptox',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => get_theme_file_path( 'admin/plugins/' ), // Default absolute path to bundled plugins.
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => ''
	);

	tgmpa( $plugins, $config );

}