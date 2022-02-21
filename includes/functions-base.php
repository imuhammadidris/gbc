<?php

/*  Base Function Class
/* ---------------------------------------------------------------------- */

if ( !class_exists('Cryptex_Base') ) {

	class Cryptex_Base {

		public $action_search = 'cryptex_action_search';
		public $action_post_share = 'cryptex_action_post_share';
		public $paths = array();
		public $directory_uri;
		private static $_instance;
		protected $used_fonts = array();
		protected $fontlist = array();

		/* 	Instance
		/* ---------------------------------------------------------------------- */

		public static function getInstance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		function __construct() {

			$this->directory_uri = get_theme_file_uri('css');

			add_action( 'template_redirect', array($this, 'predefined_config'), 1 );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles_scripts' ), 100 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );
			add_filter( 'body_class', array( $this, 'body_class' ), 5 );

			new cryptex_admin_user_profile();

			/*  Load Textdomain
			/* --------------------------------------------- */
			$this->load_textdomain();

		}

		/* 	Initialization
		/* ---------------------------------------------------------------------- */

		function body_class($classes) {
			global $post, $cryptex_config;

			if ( isset($cryptex_config['header_style']) ) {
				$classes[] = 'header-' . $cryptex_config['header_style'];
			}

			$coming_soon = absint( mad_meta( 'cryptex_coming_soon' ) );

			if ( 1 == $coming_soon ) {
				$classes[] = 'cryptex-coming-soon-page';
			}

			if ( is_front_page() ) {
				$classes[] = 'front__page';
			}

			$classes[] = $cryptex_config['sidebar_position'];

			return $classes;
		}

		public function admin_enqueue_styles_scripts() {
			$this->admin_enqueue_styles();
			$this->admin_enqueue_scripts();
		}

		public function enqueue_styles_scripts() {

			global $cryptex_settings;

			/* Vendor CSS */
			wp_enqueue_style( 'owl-carousel', get_theme_file_uri('css/owl.carousel' . (WP_DEBUG ? '' : '.min') . '.css') );
			wp_enqueue_style( 'animate', get_theme_file_uri('css/animate.css') );
			wp_enqueue_style( 'fancybox', get_theme_file_uri('js/libs/fancybox/jquery.fancybox.css') );
			wp_enqueue_style( 'chartist', get_theme_file_uri('js/libs/charts/chartist.css') );
			wp_enqueue_style( 'limarquee', get_theme_file_uri('css/liMarquee.min.css') );

			/* Theme CSS */
			wp_enqueue_style( 'font-linearicons', get_theme_file_uri('css/linear-icons.css'), array(), 1.0 );
			wp_enqueue_style( 'font-bootstrap', get_theme_file_uri('css/bootstrap-grid.min.css'), array(), 4.0 );
			wp_enqueue_style( 'font-fontello', get_theme_file_uri('css/fontello' . (WP_DEBUG ? '' : '.min') . '.css'), array(), 1.0 );

			wp_enqueue_style( 'cryptex-style', get_stylesheet_uri(), array(), null );

			if ( class_exists('WooCommerce') ) {
				wp_enqueue_style( 'cryptex-woocommerce-mod', get_theme_file_uri( 'config-woocommerce/assets/css/woocommerce-mod' . (WP_DEBUG ? '' : '.min') . '.css' ) );
			}

			if ( is_rtl() ) {
				wp_enqueue_style( 'cryptex-rtl',  get_theme_file_uri( 'css/rtl.css' ), array( 'cryptex-style' ), '1' );
			}

			wp_enqueue_style( 'cryptex-responsive', get_theme_file_uri( 'css/responsive' . ( WP_DEBUG ? '' : '.min' ) . '.css' ) , array(), 1.0 );

			// Skin Styles
			wp_deregister_style( 'cryptex-skin' );
			$prefix_name = 'skin_' . cryptex_get_blog_id() . '.css';
			$wp_upload_dir = wp_upload_dir();
			$stylesheet_dynamic_dir = $wp_upload_dir['basedir'] . '/dynamic_cryptex_dir';
			$stylesheet_dynamic_dir = str_replace('\\', '/', $stylesheet_dynamic_dir);
			$filename = trailingslashit($stylesheet_dynamic_dir) . $prefix_name;

			$version = get_option( 'cryptex_stylesheet_version' . $prefix_name );
			if ( empty($version) ) $version = '1';

			$demo = get_option( 'cryptex_demo' );
			if ( empty($demo) ) $demo = '1';

			if ( file_exists($filename) ) {
				if ( is_ssl() ) {
					$wp_upload_dir['baseurl'] = str_replace("http://", "https://", $wp_upload_dir['baseurl']);
				}
				wp_register_style( 'cryptex-skin', $wp_upload_dir['baseurl'] . '/dynamic_cryptex_dir/' . $prefix_name, null, $version );
			} else {
				wp_register_style( 'cryptex-skin', get_theme_file_uri( "css/skin-{$demo}.css" ), null, $version );
			}
			wp_enqueue_style( 'cryptex-skin' );

			// Load Google Fonts
			$google_fonts = array();
			$fonts = array( 'body', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'menu', 'sub-menu', 'vr-menu', 'vr-sub-menu' );
			foreach ( $fonts as $option ) {
				if ( isset($cryptex_settings[$option.'-font']['google']) && $cryptex_settings[$option.'-font']['google'] !== 'false' ) {
					$font = $cryptex_settings[$option.'-font']['font-family'];
					if ( !in_array($font, $google_fonts) ) {
						$google_fonts[] = $font;
					}
				}
			}

			$font_family = array();
			foreach ( $google_fonts as $font ) {

				/*
				Translators: If there are characters in your language that are not supported
				by chosen font(s), translate this to 'off'. Do not translate into your own language.
				 */
				$f = sprintf( _x( 'on', '%s font: on or off', 'cryptox' ), $font );

				if ( 'off' !== $f ) {
					$font_family[] .= $font . ':300,300italic,400,400italic,500,600,600italic,700,700italic,900,900italic%7C';
				}

			}

			if ( $font_family ) {
				$charsets = '';

				if ( isset($cryptex_settings['select-google-charset']) && $cryptex_settings['select-google-charset'] && isset($cryptex_settings['google-charsets']) && $cryptex_settings['google-charsets']) {
					$i = 0;
					foreach ( $cryptex_settings['google-charsets'] as $charset ) {
						if ( $i == 0 ) {
							$charsets .= $charset;
						} else {
							$charsets .= ",".$charset;
						}
						$i++;
					}
				}

				$fonts_url = add_query_arg( array(
					'family' => urlencode( implode('|', $font_family) ),
					'subset' => urlencode( $charsets )
				), '//fonts.googleapis.com/css' );

				wp_enqueue_style( 'cryptex-google-fonts', esc_url_raw($fonts_url) . $charsets );
			}

			// Enqueue scripts

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			$scripts_deps = array( 'jquery', 'jquery-ui-core', 'jquery-ui-tabs', 'google-maps' );

			// Google Maps.
			wp_register_script( 'google-maps', cryptex_get_google_maps_api_url(), array(), '3.exp' );

			/* Include Libs & Plugins */
			wp_enqueue_script( 'modernizr', get_theme_file_uri('js/libs/jquery.modernizr.min.js') );
			wp_enqueue_script( 'jquery-owl-carousel', get_theme_file_uri('js/libs/owl.carousel.min.js'), $scripts_deps, '', true);
			wp_enqueue_script( 'jquery-isotope', get_theme_file_uri('js/libs/isotope.pkgd.min.js'), $scripts_deps, '', true);
			wp_enqueue_script( 'jquery-fancybox', get_theme_file_uri('js/libs/fancybox/jquery.fancybox.min.js'), $scripts_deps, '', true);
			wp_enqueue_script( 'jquery-limarquee', get_theme_file_uri('js/libs/jquery.liMarquee.min.js'), $scripts_deps, '', true);
			wp_enqueue_script( 'jquery-countdown', get_theme_file_uri('js/libs/jquery.countdown.min.js'), $scripts_deps, '', true);

			wp_register_script( 'd3', get_theme_file_uri('js/libs/d3.min.js'), $scripts_deps, '', true);
			wp_register_script( 'moment', get_theme_file_uri('js/libs/moment.min.js'), $scripts_deps, '', true);
			wp_register_script( 'chartist', get_theme_file_uri('js/libs/charts/chartist.min.js'), $scripts_deps, '', true);

			wp_register_script( 'cryptex-header-widget', get_theme_file_uri('js/libs/cryptex-header-widget.js'), $scripts_deps, '', true);

			/* Theme files */
			wp_enqueue_script( 'cryptex-core', get_theme_file_uri('js/cryptex-core' . ( WP_DEBUG ? '' : '.min' ) . '.js'), $scripts_deps, '', true );

			if ( isset($cryptex_settings['js-code-head']) && $cryptex_settings['js-code-head']) {
				wp_add_inline_script( 'cryptex-core', $cryptex_settings['js-code-head'] );
			}

			wp_localize_script( 'cryptex-core', 'cryptex_global_vars', array(
				'template_base_uri' => get_template_directory_uri() . '/',
				'ajax_nonce' => wp_create_nonce('ajax-nonce'),
				'ajaxurl' => admin_url('admin-ajax.php'),
				'rtl' => is_rtl() ? 1 : 0,
			) );

		}

		/* 	Enqueue Admin Styles
		/* ---------------------------------------------------------------------- */

		public function admin_enqueue_styles() {
			wp_enqueue_style( 'cryptex-admin', $this->directory_uri . '/admin.css', false);
		}

		/*  Enqueue Admin Scripts
		/* ---------------------------------------------------------------------- */

		public function admin_enqueue_scripts() {

			if ( function_exists('add_thickbox') )
				add_thickbox();

			wp_enqueue_media();
			wp_enqueue_script( 'cryptex-admin', get_theme_file_uri('js/cryptex-admin.js') );

		}

		/* 	Load Textdomain
		/* ---------------------------------------------------------------------- */

		public function load_textdomain () {
			load_theme_textdomain( 'cryptox', get_template_directory()  . '/lang' );
		}

		/*	Check page layout
		/* ---------------------------------------------------------------------- */

		public function check_page_layout () {
			global $cryptex_config, $cryptex_settings;

			$result = false;
			$sidebar_position = 'page-layout';

			$post_id = cryptex_post_id();

			if ( is_page() ) { $sidebar_position = 'page-layout'; }

			if ( is_archive() || is_front_page() || is_search() || is_attachment() ) { $sidebar_position = 'post-archive-layout'; }

			if ( is_single() ) { $sidebar_position = 'post-single-layout'; }

			if ( is_singular() ) {
				$result = trim(get_post_meta( $post_id, 'cryptex_page_sidebar_position', true ));
			}

			if ( is_singular('portfolio') ) {
				$sidebar_position = 'portfolio-archive-layout';
			}

			if ( is_singular('ico') ) {
				$sidebar_position = 'ico-archive-layout';
			}

			if ( is_singular('services') ) {
				$sidebar_position = 'services-page-layout';
			}

			if ( is_singular('tribe_events') || is_post_type_archive('tribe_events') ) {
				$sidebar_position = 'events-page-layout';
			}

			if ( is_singular('team-members') ) {
				$sidebar_position = 'team-members-archive-layout';
			}

			if ( cryptex_is_shop_installed() ) {

				if ( cryptex_is_realy_woocommerce_page(true) || cryptex_is_shop_archive() || cryptex_is_product_category() || cryptex_is_product_tax() ) {
					$result = $cryptex_settings['product-archive-layout'];
				}

				if ( is_checkout() ) {
					$result = 'no-sidebar';
				}

				if ( cryptex_is_product() ) {
					$result = $cryptex_settings['product-single-layout'];
				}

			}

			if ( is_404() ) { $result = 'no-sidebar'; }

			if ( !$result ) {
				$result = $cryptex_settings[$sidebar_position];
			}

			if ( !$result ) {
				$result = 'no-sidebar';
			}

			$sidebar = $cryptex_settings['sidebar'];
			$page_sidebar = trim( get_post_meta( cryptex_post_id(), 'cryptex_page_sidebar', true ) );

			if ( is_singular( array('page', 'post') ) && !empty($page_sidebar) ) {
				$sidebar = $page_sidebar;
			}

			if ( is_singular('practice') ) {
				$sidebar = $cryptex_settings['practice-sidebar'];
			} elseif ( is_singular('team-members') ) {
				$sidebar = $cryptex_settings['team-members-sidebar'];
			} elseif ( cryptex_is_realy_woocommerce_page() ) {
				$sidebar = $cryptex_settings['product-sidebar'];
			} elseif ( is_singular('ico') ) {
				$sidebar = $cryptex_settings['ico-sidebar'];
			}

			if ( !is_active_sidebar($sidebar) ) {
				$result = 'no-sidebar';
			}

			if ( $result ) {
				$cryptex_config['sidebar_position'] = $result;
				$cryptex_config['sidebar'] = $sidebar;
			}

		}

		public function check_header_classes() {
			global $cryptex_config, $cryptex_settings;

			$result = array();
			$post_id = cryptex_post_id();

			$header_style = $cryptex_settings['header-style'];

			$meta_header_style = trim( get_post_meta( $post_id, 'cryptex_header_style', true ) );

			if ( !empty($meta_header_style) ) { $header_style = $meta_header_style; }

			if ( $cryptex_settings['header-sticky-menu']) {
				$result['sticky_header'] = 'sticky-header';
			}

			$result['header_style'] = $header_style;

			$result = array_unique($result);

			$cryptex_config['header_classes'] = implode( ' ', array_values($result) );
			$cryptex_config['header_style'] = $result['header_style'];
		}

		public function check_footer_classes() {
			global $cryptex_config;
			$classes = array();

			$cryptex_config['footer_classes'] = implode( ' ', array_values($classes) );
		}

		public function check_page_content_classes() {
			global $cryptex_config;

			$result = array();
			$result[] = 'page-content-wrap';
			$result[] = $cryptex_config['sidebar_position'];

			$cryptex_config['page_content_classes'] = implode( ' ', array_filter(array_values($result)) );
		}

		public function predefined_config() {
			$this->check_page_layout();
			$this->check_header_classes();
			$this->check_footer_classes();
			$this->check_page_content_classes();
		}

		/* 	Instance
		/* ---------------------------------------------------------------------- */

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

	}

	if ( ! function_exists('cryptex_base') ) {

		function cryptex_base() {
			// Load required classes and functions
			return Cryptex_Base::getInstance();
		}

		cryptex_base();

	}

}