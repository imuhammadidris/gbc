<?php

function cryptex_check_theme_options() {
	// check default options
	global $cryptex_settings;

	ob_start();
	include( get_theme_file_path('admin/framework/theme-options/default-options.php') );
	$options = ob_get_clean();
	$default_settings = json_decode($options, true);

	foreach ( $default_settings as $key => $value ) {

		if ( is_array($value) ) {
			foreach ( $value as $key1 => $value1 ) {
				if ((!isset($cryptex_settings[$key][$key1]) || !$cryptex_settings[$key][$key1])) {
					$cryptex_settings[$key][$key1] = $default_settings[$key][$key1];
				}
			}
		} else {
			if ( !isset($cryptex_settings[$key]) ) {
				$cryptex_settings[$key] = $default_settings[$key];
			}
		}
	}

	return $cryptex_settings;
}

if ( !function_exists('cryptex_options_header_types') ) {
	function cryptex_options_header_types() {
		return array(
			'style-1' => array('alt' => esc_html__('Header Style 1', 'cryptox'), 'img' => get_theme_file_uri('admin/framework/theme-options/headers/header_1.jpg')),
			'style-2' => array('alt' => esc_html__('Header Style 2', 'cryptox'), 'img' => get_theme_file_uri('admin/framework/theme-options/headers/header_2.jpg')),
			'style-3' => array('alt' => esc_html__('Header Style 3', 'cryptox'), 'img' => get_theme_file_uri('admin/framework/theme-options/headers/header_3.jpg'))
		);
	}
}

if ( !function_exists('cryptex_options_layouts') ) {
	function cryptex_options_layouts() {
		return array(
			'no-sidebar' => array( 'alt' => esc_html__('Without Sidebar', 'cryptox'), 'img' => get_theme_file_uri('admin/framework/theme-options/layouts/layout-full.jpg') ),
			'left-sidebar' => array( 'alt' => esc_html__('Left Sidebar', 'cryptox'), 'img' => get_theme_file_uri('admin/framework/theme-options/layouts/layout-left.jpg') ),
			'right-sidebar' => array( 'alt' => esc_html__('Right Sidebar', 'cryptox'), 'img' => get_theme_file_uri('admin/framework/theme-options/layouts/layout-right.jpg') )
		);
	}
}

if ( !function_exists('cryptex_options_sidebars') ) {
	function cryptex_options_sidebars() {
		return array(
			'left-sidebar',
			'right-sidebar'
		);
	}
}

if ( !function_exists('cryptex_categories_orderby') ) {
	function cryptex_categories_orderby() {
		return array(
			"id" => esc_html__("ID", 'cryptox'),
			"name" => esc_html__("Name", 'cryptox'),
			"slug" => esc_html__("Slug", 'cryptox'),
			"count" => esc_html__("Count", 'cryptox')
		);
	}
}

if ( !function_exists('cryptex_product_columns') ) {
	function cryptex_product_columns() {
		return array(
			2 => 2,
			3 => 3,
			4 => 4
		);
	}
}

if ( !function_exists('cryptex_blog_columns') ) {
	function cryptex_blog_columns() {
		return array(
			1 => 1,
			2 => 2,
			3 => 3
		);
	}
}