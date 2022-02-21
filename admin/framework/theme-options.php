<?php

/**
 * Cryptex Theme Options
 */
if ( !class_exists('Cryptex_Admin') ) {

	class Cryptex_Admin {

		public function __construct() {
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts', ), 100 );
		}

		public function enqueue_scripts() {
			wp_localize_script('cryptex-extend-admin', 'cryptex_admin_global_vars', array(
				'installing_text' => esc_html__( 'Installing', 'cryptox' ),
				'import_theme_options_text' => esc_html__( 'Importing theme options', 'cryptox' ),
				'finished_text' => esc_html__( 'Finished! Please visit your site.', 'cryptox' ),
			));
		}

		public function admin_init() {

			if ( current_user_can( 'edit_theme_options' ) )  {

				if ( isset($_GET['theme_settings_export'] ) ) {

					// Widget settings
					$widget_settings = json_encode($this->export_widgets());

					// Sidebar settings
					$sidebar_settings = json_encode($this->export_sidebars());

					// Meta settings
					$meta_settings = json_encode($this->export_metadata());

					echo '<pre>'."\n"; echo '$widget_settings = "'; print_r($widget_settings); echo '";</pre>';
					echo '<pre>'."\n"; echo '$sidebar_settings = "'; print_r($sidebar_settings); echo '";</pre>'."\n\n";
					echo '<pre>'."\n"; echo '$meta_settings = "'; print_r($meta_settings); echo '";</pre>'."\n\n";
					exit();

				}

			}

		}

		public function export_widgets() {

			global $wp_registered_widgets;
			$saved_widgets = $options = array();

			foreach ($wp_registered_widgets as $registered) {
				if ( isset($registered['callback'][0]) && isset($registered['callback'][0]->option_name)) {
					$options[] = $registered['callback'][0]->option_name;
				}
			}

			foreach ($options as $key) {
				$widget = get_option($key, array());
				$treshhold = 1;
				if (array_key_exists("_multiwidget", $widget)) $treshhold = 2;

				if ($treshhold <= count($widget)) {
					$saved_widgets[$key] = $widget;
				}
			}

			$saved_widgets['sidebars_widgets'] = get_option('sidebars_widgets');
			return $saved_widgets;
		}

		function export_sidebars() {
			$custom_sidebars = get_option('cryptex_sidebars');

			if ( !empty($custom_sidebars) ) {
				return $custom_sidebars;
			}
			return '';
		}

		public function export_metadata() {
			global $wpdb;

			$meta_settings = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}product_catmeta", ARRAY_A);
			return $meta_settings;
		}

	}

	new Cryptex_Admin();

}

require_once( get_template_directory() . '/admin/framework/functions.php' );

if ( get_option('cryptex_init_theme', '0') != '1' ) { cryptex_check_theme_options(); }

require_once( get_theme_file_path( 'admin/lic.php' ) );