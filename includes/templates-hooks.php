<?php

if ( !class_exists('Cryptex_Hooks') ) {

	class Cryptex_Hooks {

		function __construct() {

			add_action( 'wp_loaded', array( $this, 'wp_loaded' ) );

		}

		public function theme_loader() { ?><div class="loader"><div id='qLbar'></div></div><?php }

		public function wp_loaded() {
			$this->add_hooks();
		}

		public function add_hooks() {
			add_action( 'cryptex_body_append', array( $this, 'theme_loader' ) );
			add_action( 'cryptex_header_after', array( $this, 'header_after_hook' ) );
			add_action( 'cryptex_header_layout', array( $this, 'template_header_layout_hook') );
			add_action( 'cryptex_footer_append', array( $this, 'template_footer_top' ) );

			add_action( 'cryptex_header_after', array( $this, 'template_header_ccn_widget' ) );

			if ( class_exists('Cryptex_Widgets_Meta_Box') ) {
				add_action( 'cryptex_footer_append', array( $this, 'template_footer_widgets' ) );
			}

			add_action( 'cryptex_footer_append', array( $this, 'template_part_copyright' ) );
		}

		public function template_header_ccn_widget() {
			get_template_part( 'template-parts/header/header', 'ccn-widget' );
		}

		public function template_header_layout_hook($type) {
			get_template_part( 'template-parts/header/header', $type );
		}

		public function header_after_hook() {
			get_template_part( 'template-parts/page/title' );
		}

		public function template_footer_top() {
			get_template_part( 'template-parts/footer/footer', 'top' );
		}

		public function template_footer_widgets() {
			get_template_part( 'template-parts/footer/footer', 'widgets' );
		}

		public function template_part_copyright() {
			get_template_part( 'template-parts/footer/footer', 'copyright' );
		}

		/* 	Get Cookie
		/* ---------------------------------------------------------------------- */

		public static function getcookie( $name ) {
			if ( isset( $_COOKIE[$name] ) )
				return maybe_unserialize( stripslashes( $_COOKIE[$name] ) );

			return array();
		}

	}

	new Cryptex_Hooks();
}
