<?php

add_action( 'redux/options/cryptex_settings/saved', 'cryptex_save_theme_settings', 10, 2 );
add_action( 'redux/options/cryptex_settings/import', 'cryptex_save_theme_settings', 10, 2 );
add_action( 'redux/options/cryptex_settings/reset', 'cryptex_save_theme_settings' );
add_action( 'redux/options/cryptex_settings/section/reset', 'cryptex_save_theme_settings' );

if ( !function_exists('cryptex_save_theme_settings') ) {

	function cryptex_save_theme_settings() {
		global $cryptex_settings, $cryptex_redux_settings;

		update_option('cryptex_init_theme', '1');

		$reduxFramework = $cryptex_redux_settings->ReduxFramework;
		$template_dir = get_template_directory();

		// config file
		ob_start();
		include $template_dir . '/admin/framework/theme-options/config-less.php';
		$_config_css = ob_get_clean();

		$filename = $template_dir . '/less/config.less';

		if ( file_exists($filename) ) {
			@unlink($filename);
		}
		$reduxFramework->filesystem->execute('put_contents', $filename, array('content' => $_config_css));

		try {

			ob_start();
			$less = new lessc;
			echo ' ' . $less->compileFile( $template_dir . '/less/skin.less' );

			$_config_css = ob_get_clean();

			$prefix_name = 'skin_' . get_current_blog_id() . '.css';
			$wp_upload_dir  = wp_upload_dir();
			$stylesheet_dynamic_dir = $wp_upload_dir['basedir'] . '/dynamic_cryptex_dir';
			$stylesheet_dynamic_dir = str_replace('\\', '/', $stylesheet_dynamic_dir);

			cryptex_backend_create_folder($stylesheet_dynamic_dir);

			$filename = trailingslashit($stylesheet_dynamic_dir) . $prefix_name;

			$create = $reduxFramework->filesystem->execute( 'put_contents', $filename, array( 'content' => $_config_css) );

			if ( $create === true ) {
				update_option( 'cryptex_stylesheet_version' . $prefix_name, uniqid() );
			}

		} catch (Exception $e) {}

	}

}


/*  Create folder
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_backend_create_folder') ) {
	function cryptex_backend_create_folder(&$folder, $addindex = true) {
		if ( is_dir($folder) && $addindex == false ) {
			return true;
		}

		$created = wp_mkdir_p(trailingslashit($folder));

		if ( $addindex == false ) return $created;

		return $created;
	}
}

