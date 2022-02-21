<?php
/**
 * Cryptex functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 */

/**
 * Include the main Cryptex class.
 */
require_once( get_theme_file_path('includes/class-cryptex.php') );

function Cryptex() {
	return Cryptex::get_instance();
}
Cryptex();

/* Load Base Functions
/* ---------------------------------------------------------------------- */
require_once( get_theme_file_path('includes/class-admin-user-profile.php') );
require_once( get_theme_file_path('includes/functions-base.php') );
require_once( get_theme_file_path('includes/functions-core.php') );
require_once( get_theme_file_path('includes/helpers/theme-helper.php') );
require_once( get_theme_file_path('includes/helpers/post-format-helper.php') );

/*  Menu
/* ---------------------------------------------------------------------- */

require_once( get_theme_file_path('includes/menu.php') );

/*  Include Plugins
/* ---------------------------------------------------------------------- */
require_once( get_theme_file_path( 'includes/plugins/init.php' ) );

/*  Theme support & Theme setup
/* ---------------------------------------------------------------------- */

if ( ! function_exists('cryptex_setup') ) :
	function cryptex_setup() {

		define('ALLOW_UNFILTERED_UPLOADS', true);

		$GLOBALS['content_width'] = apply_filters( 'cryptex_content_width', 1380 );

		// Load theme textdomain
		load_theme_textdomain( 'cryptox', get_template_directory()  . '/lang' );
		load_child_theme_textdomain( 'cryptox', get_stylesheet_directory() . '/lang' );

		/**
		 * Cryptex admin options
		 */
		require_once( get_theme_file_path('admin/framework/admin.php') );
		require_once( get_theme_file_path('admin/framework/theme-options.php') );
		cryptex_check_theme_options();
		global $pagenow;

		// Post Formats Support
		add_theme_support('post-formats', array( 'gallery', 'quote', 'video', 'audio', 'link' ));

		// Post Thumbnails Support
		add_theme_support('post-thumbnails');

		// Add default posts and comments RSS feed links to head
		add_theme_support('automatic-feed-links');

		add_theme_support('title-tag');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menu( 'primary', 'Primary Menu' );
		register_nav_menu( 'secondary', 'Secondary Menu' );

		add_image_size( 'cryptex-455x300-center-center', 455, 300, array( 'center', 'center' ) );
		add_image_size( 'cryptex-660x415-center-center', 660, 415, array( 'center', 'center' ) );
		add_image_size( 'cryptex-430x465-center-center', 430, 465, array( 'center', 'center' ) );
		add_image_size( 'cryptex-950x620-center-center', 950, 620, array( 'center', 'center' ) );
		add_image_size( 'cryptex-315x310-center-center', 315, 310, array( 'center', 'center' ) );
		add_image_size( 'cryptex-1120x520-center-center', 1120, 520, array( 'center', 'center' ) );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_editor_style( array( 'editor-style.css' ) );

	}
endif;

add_action( 'after_setup_theme', 'cryptex_setup', 100 );

/*  Register Widget Areas
/* ----------------------------------------------------------------- */

if ( !function_exists('cryptex_widgets_register') ) {

	function cryptex_widgets_register () {

		$before_widget = '<div id="%1$s" class="widget %2$s">';

		$widget_args = array(
			'before_widget' => $before_widget,
			'after_widget' => '</div>',
			'before_title' => '<h6 class="widget-title">',
			'after_title' => '</h6>'
		);

		// General Widget Area
		register_sidebar(array(
			'name' => esc_html__('General Widget Area', 'cryptox'),
			'id' => 'general-widget-area',
			'description'   => esc_html__('For all pages and posts.', 'cryptox'),
			'before_widget' => $widget_args['before_widget'],
			'after_widget' => $widget_args['after_widget'],
			'before_title' => $widget_args['before_title'],
			'after_title' => $widget_args['after_title']
		));

		register_sidebar(array(
			'name' => esc_html__('Widget Area Left', 'cryptox'),
			'id' => 'widget-area-1',
			'description'   => esc_html__('For home page blog left area.', 'cryptox'),
			'before_widget' => $widget_args['before_widget'],
			'after_widget' => $widget_args['after_widget'],
			'before_title' => $widget_args['before_title'],
			'after_title' => $widget_args['after_title']
		));

		register_sidebar(array(
			'name' => esc_html__('Widget Area Right', 'cryptox'),
			'id' => 'widget-area-2',
			'description'   => esc_html__('For home page blog right area.', 'cryptox'),
			'before_widget' => $widget_args['before_widget'],
			'after_widget' => $widget_args['after_widget'],
			'before_title' => $widget_args['before_title'],
			'after_title' => $widget_args['after_title']
		));

		register_sidebar(array(
			'name' => esc_html__('ICO Widget Area', 'cryptox'),
			'id' => 'ico-widget-area',
			'description'   => esc_html__('For ICO pages.', 'cryptox'),
			'before_widget' => $widget_args['before_widget'],
			'after_widget' => $widget_args['after_widget'],
			'before_title' => $widget_args['before_title'],
			'after_title' => $widget_args['after_title']
		));

		register_sidebar(array(
			'name' => esc_html__('Team Members Widget Area', 'cryptox'),
			'id' => 'team-members-widget-area',
			'description'   => esc_html__('For all team members pages.', 'cryptox'),
			'before_widget' => $widget_args['before_widget'],
			'after_widget' => $widget_args['after_widget'],
			'before_title' => $widget_args['before_title'],
			'after_title' => $widget_args['after_title']
		));

		// Shop Widget Area
		register_sidebar(array(
			'name' => esc_html__('Shop Widget Area', 'cryptox'),
			'id' => 'shop-widget-area',
			'description'   => esc_html__('For WooCommerce pages.', 'cryptox'),
			'before_widget' => $widget_args['before_widget'],
			'after_widget' => $widget_args['after_widget'],
			'before_title' => $widget_args['before_title'],
			'after_title' => $widget_args['after_title']
		));

		for ( $i = 1; $i <= 10; $i++ ) {
			register_sidebar(array(
				'name' => 'Footer Row - widget ' . $i,
				'id' => 'footer-row-' . $i,
				'before_widget' => $widget_args['before_widget'],
				'after_widget' => $widget_args['after_widget'],
				'before_title' => $widget_args['before_title'],
				'after_title' => $widget_args['after_title']
			));

		}
	}

	add_action( 'widgets_init', 'cryptex_widgets_register' );

}

/*  Load hooks
/* ---------------------------------------------------------------------- */
if ( !is_admin() ) {
	require_once( get_theme_file_path('includes/templates-hooks.php') );
}

/*  Custom template tags for this theme.
/* ---------------------------------------------------------------------- */
require_once( get_theme_file_path('includes/template-tags.php') );

/* Load Composer compatibility file
 * https://vc.wpbakery.com/
/* ---------------------------------------------------------------------- */

if ( class_exists('Vc_Manager') ) {
	require_once( get_theme_file_path('config-composer/config.php') );
}

/* Load WooCommerce compatibility file
 * https://wordpress.com/
/* ---------------------------------------------------------------------- */

if ( class_exists('WooCommerce') ) {
	require_once( get_theme_file_path('config-woocommerce/config.php') );
}

/* Plugin integrations
/* ---------------------------------------------------------------------- */

require_once( get_theme_file_path('includes/integrations.php') );

/* Load WPML compatibility file
 * https://wpml.org/
/* ---------------------------------------------------------------------- */

if ( class_exists('SitePress') ) {
	require_once( get_theme_file_path('config-wpml/config.php') );
}

// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );

// Disables the block editor from managing widgets.
add_filter( 'use_widgets_block_editor', '__return_false' );

/*  Get user name
/* ---------------------------------------------------------------------- */

if ( !function_exists("cryptex_get_user_name") ) {

	function cryptex_get_user_name($current_user) {

		if ( !$current_user->user_firstname && !$current_user->user_lastname ) {

			if ( cryptex_is_shop_installed() ) {

				$firstname_billing = get_user_meta( $current_user->ID, "billing_first_name", true );
				$lastname_billing = get_user_meta( $current_user->ID, "billing_last_name", true );

				if ( !$firstname_billing && !$lastname_billing ) {
					$user_name = $current_user->user_nicename;
				} else {
					$user_name = $firstname_billing . ' ' . $lastname_billing;
				}

			} else {
				$user_name = $current_user->user_nicename;
			}

		} else {
			$user_name = $current_user->user_firstname . ' ' . $current_user->user_lastname;
		}

		return $user_name;
	}

}