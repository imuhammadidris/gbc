<?php
/**
 * Cryptex Settings Options
 */

if ( !class_exists('cryptex_redux_settings') ) {

	class cryptex_redux_settings {

		public $args = array();
		public $sections = array();
		public $theme;
		public $version;
		public $ReduxFramework;

		public function __construct() {

			if ( !class_exists('ReduxFramework') ) {
				return;
			}

			$this->initSettings();
		}

		public function initSettings() {

			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();

			// Create the sections and fields
			$this->setSections();

			if ( !isset($this->args['opt_name']) ) { return; }

			$this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );

		}

		public function arrayNumber($from = 0, $to = 50, $step = 1, $array = array()) {
			for ($i = $from; $i <= $to; $i += $step) {
				$array[$i] = $i;
			}
			return $array;
		}

		public function setSections() {

			$page_layouts = cryptex_options_layouts();
			$sidebars = cryptex_options_sidebars();
			$header_style = cryptex_options_header_types();

			$this->sections[] = array(
				'icon' => 'el-icon-dashboard',
				'icon_class' => 'icon',
				'title' => esc_html__('General', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'page-layout',
						'type' => 'image_select',
						'title' => esc_html__('Page Layout', 'cryptox'),
						'options' => $page_layouts,
						'default' => 'right-sidebar'
					),
					array(
						'id' => 'sidebar',
						'type' => 'select',
						'title' => esc_html__('Select Sidebar', 'cryptox'),
						'required' => array( 'page-layout','equals', $sidebars ),
						'data' => 'sidebars',
						'default' => 'general-widget-area'
					),
				)
			);

			// Skin Styling
			$this->sections[] = array(
				'icon' => 'el-icon-broom',
				'icon_class' => 'icon',
				'title' => esc_html__('Skin', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'selection-color',
						'type' => 'color',
						'desc' => esc_html__('The ::selection selector matches the portion of an element that is selected by a user.', 'cryptox'),
						'title' => esc_html__('Selection background color', 'cryptox'),
						'default'   => '#1e46a5',
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Typography', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'select-google-charset',
						'type' => 'switch',
						'title' => esc_html__('Select Google Font Character Sets', 'cryptox'),
						'default' => false,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'google-charsets',
						'type' => 'button_set',
						'title' => esc_html__('Google Font Character Sets', 'cryptox'),
						'multi' => true,
						'required' => array('select-google-charset', 'equals', true),
						'options'=> array(
							'cyrillic' => 'Cyrrilic',
							'cyrillic-ext' => 'Cyrrilic Extended',
							'greek' => 'Greek',
							'greek-ext' => 'Greek Extended',
							'khmer' => 'Khmer',
							'latin' => 'Latin',
							'latin-ext' => 'Latin Extneded',
							'vietnamese' => 'Vietnamese'
						),
						'default' => array('latin','greek-ext','cyrillic','latin-ext','greek','cyrillic-ext','vietnamese','khmer')
					),
					array(
						'id' => 'body-font',
						'type' => 'typography',
						'title' => esc_html__('Body Font', 'cryptox'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'units' => 'em',
						'default'=> array(
							'color' => "#777",
							'google' => true,
							'font-weight' => '400',
							'font-family' => 'Roboto',
							'font-size' => '1',
							'line-height' => '1.5'
						),
					),
					array(
						'id' => 'h1-font',
						'type' => 'typography',
						'title' => esc_html__('H1 Font', 'cryptox'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'line-height' => false,
						'units' => 'em',
						'default'=> array(
							'color' => "#333",
							'google' => true,
							'font-weight' => '400',
							'font-family' => 'Source Sans Pro',
							'font-size' => '3.75',
						),
					),
					array(
						'id' => 'h2-font',
						'type' => 'typography',
						'title' => esc_html__('H2 Font', 'cryptox'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'line-height' => false,
						'units' => 'em',
						'default'=> array(
							'color' => "#333",
							'google' => true,
							'font-weight' => '400',
							'font-family' => 'Source Sans Pro',
							'font-size' => '3',
						),
					),
					array(
						'id' => 'h3-font',
						'type' => 'typography',
						'title' => esc_html__('H3 Font', 'cryptox'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'line-height' => false,
						'units' => 'em',
						'default'=> array(
							'color' => "#333",
							'google' => true,
							'font-weight' => '400',
							'font-family' => 'Source Sans Pro',
							'font-size' => '2.25',
						),
					),
					array(
						'id'=>'h4-font',
						'type' => 'typography',
						'title' => esc_html__('H4 Font', 'cryptox'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'line-height' => false,
						'units' => 'em',
						'default'=> array(
							'color' => "#333",
							'google' => true,
							'font-weight' => '400',
							'font-family' => 'Source Sans Pro',
							'font-size' => '1.875',
						),
					),
					array(
						'id' => 'h5-font',
						'type' => 'typography',
						'title' => esc_html__('H5 Font', 'cryptox'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'line-height' => false,
						'units' => 'em',
						'default'=> array(
							'color' => "#333",
							'google' => true,
							'font-weight' => '400',
							'font-family' => 'Source Sans Pro',
							'font-size' => '1.375',
						),
					),
					array(
						'id' => 'h6-font',
						'type' => 'typography',
						'title' => esc_html__('H6 Font', 'cryptox'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'line-height' => false,
						'units' => 'em',
						'default'=> array(
							'color' => "#333",
							'google' => true,
							'font-weight' => '400',
							'font-family' => 'Source Sans Pro',
							'font-size' => '1.125',
						),
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Backgrounds', 'cryptox'),
				'fields' => array(
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('Body Background', 'cryptox'),
						'notice' => false
					),
					array(
						'id' => 'body-bg',
						'type' => 'background',
						'title' => esc_html__('Background', 'cryptox'),
						'default'  => array(
							'background-color' => '#f4f4f4',
						)
					)
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Main Menu', 'cryptox'),
				'fields' => array(
					array(
						'id' => '12',
						'type' => 'info',
						'title' => esc_html__( 'Top Level Menu Item', 'cryptox' ),
						'notice' => false
					),
					array(
						'id' => 'menu-font',
						'type' => 'typography',
						'title' => esc_html__('Menu Font', 'cryptox'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'line-height' => false,
						'color' => false,
						'units' => 'em',
						'default'=> array(
							'google' => true,
							'font-weight' => '400',
							'font-family'=> 'Roboto',
							'font-size' => '1',
						),
					),
					array(
						'id' => 'menu-text-transform',
						'type' => 'button_set',
						'title' => esc_html__('Text Transform', 'cryptox'),
						'options' => array(
							'none' => esc_html__('None', 'cryptox'),
							'capitalize' => esc_html__('Capitalize', 'cryptox'),
							'uppercase' => esc_html__('Uppercase', 'cryptox'),
							'lowercase' => esc_html__('Lowercase', 'cryptox'),
							'initial' => esc_html__('Initial', 'cryptox')
						),
						'default' => 'uppercase'
					),
					array(
						'id' => 'primary-toplevel-link-color',
						'type' => 'link_color',
						'active' => false,
						'hover' => true,
						'title' => esc_html__('Link Color', 'cryptox'),
						'default' => array(
							'regular' => '#fff',
							'hover' => '#fff',
						)
					),
					array(
						'id'=>'231',
						'type' => 'info',
						'title' => esc_html__('Sub Menu', 'cryptox'),
						'notice' => false
					),
					array(
						'id' => 'sub-menu-font',
						'type' => 'typography',
						'title' => esc_html__('Sub Menu Font', 'cryptox'),
						'google' => true,
						'subsets' => false,
						'font-style' => false,
						'text-align' => false,
						'line-height' => false,
						'color' => false,
						'units' => 'em',
						'default'=> array(
							'google' => true,
							'font-weight' => '400',
							'font-family'=> 'Roboto',
							'font-size' => '1'
						),
					),
					array(
						'id' => 'sub-menu-text-color',
						'type' => 'link_color',
						'title' => esc_html__('Link Color', 'cryptox'),
						'default' => array(
							'regular' => '#fff',
							'hover' => '#fff',
							'active' => '#fff'
						)
					),
					array(
						'id' => '131',
						'type' => 'info',
						'title' => esc_html__('Mobile Menu', 'cryptox'),
						'notice' => false
					),
					array(
						'id' => 'mobile-menu-active-color',
						'type' => 'color',
						'title' => esc_html__('Background Color for active toplevel link', 'cryptox'),
						'default' => '#51a3ff',
						'validate' => 'color',
					)
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Footer', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'footer-bg',
						'type' => 'background',
						'title' => esc_html__('Background', 'cryptox'),
						'default' => array(
							'background-color' => '#1d1d1d',
							'background-image' => '',
							'background-size' => 'cover',
							'background-position' => 'center center',
							'background-repeat' => 'no-repeat'
						)
					),
					array(
						'id' => 'footer-heading-color',
						'type' => 'color',
						'title' => esc_html__('Heading Color', 'cryptox'),
						'default' => '#ffffff',
						'validate' => 'color',
					),
				)
			);

			// Header Settings
			$this->sections[] = array(
				'icon' => 'el-icon-website',
				'icon_class' => 'icon',
				'title' => esc_html__('Header', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'header-sticky-menu',
						'type' => 'switch',
						'title' => esc_html__('Sticky Navigation', 'cryptox'),
						'default' => true,
						'desc' => esc_html__('The sticky navigation menu is a vital part of a website, helping users move between pages and find desired information.', 'cryptox'),
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => '235',
						'type' => 'info',
						'title' => esc_html__('Social Links', 'cryptox'),
						'notice' => false
					),
					array(
						'id' => 'show-header-social-links',
						'type' => 'switch',
						'title' => esc_html__('Show Social Links', 'cryptox'),
						'default' => false,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => "header-social-facebook",
						'type' => 'text',
						'title' => esc_html__('Facebook', 'cryptox'),
						'required' => array('show-header-social-links', 'equals', true),
						'default' => '#'
					),
					array(
						'id' => "header-social-twitter",
						'type' => 'text',
						'title' => esc_html__('Twitter', 'cryptox'),
						'required' => array('show-header-social-links', 'equals', true),
						'default' => '#'
					),
					array(
						'id' => "header-social-googleplus",
						'type' => 'text',
						'title' => esc_html__('Google Plus', 'cryptox'),
						'required' => array('show-header-social-links', 'equals', true),
						'default' => '#'
					),
					array(
						'id' => "header-social-linkedin",
						'type' => 'text',
						'title' => esc_html__('LinkedIn', 'cryptox'),
						'required' => array('show-header-social-links', 'equals', true),
						'default' => '#'
					),
					array(
						'id' => '1',
						'type' => 'info',
						'title' => esc_html__('If header style is like 1', 'cryptox'),
						'notice' => false
					),
					array(
						'id' => 'header-style-1-bg',
						'type' => 'background',
						'title' => esc_html__('Background', 'cryptox'),
						'default' => array(
							'background-color' => 'transparent',
							'background-image' => get_theme_file_uri('images/header-style-1-bg.jpg'),
							'background-size' => 'cover',
							'background-attachment' => 'fixed',
							'background-position' => 'center center',
							'background-repeat' => 'no-repeat'
						)
					),
					array(
						'id' => 'header-style-1-button',
						'type' => 'switch',
						'title' => esc_html__('Show button', 'cryptox'),
						'default' => false,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'header-style-1-button-link',
						'type' => 'text',
						'title' => esc_html__( 'Button Link', 'cryptox' ),
						'required' => array('header-style-1-button', 'equals', true),
						'default' => ''
					),
					array(
						'id' => 'header-style-1-button-text',
						'type' => 'text',
						'title' => esc_html__( 'Button Text', 'cryptox' ),
						'required' => array('header-style-1-button', 'equals', true),
						'default' => esc_html__('Subscribe', 'cryptox')
					),
					array(
						'id' => 'header-style-1-search',
						'type' => 'switch',
						'title' => esc_html__('Show search', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'header-style-1-cart',
						'type' => 'switch',
						'title' => esc_html__('Show cart', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'header-style-1-show-language',
						'type' => 'switch',
						'title' => esc_html__('Show language', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => '34',
						'type' => 'info',
						'title' => esc_html__('If header style is like 2', 'cryptox'),
						'notice' => false
					),
					array(
						'id' => 'header-style-2-search',
						'type' => 'switch',
						'title' => esc_html__('Show search', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'header-style-2-button',
						'type' => 'switch',
						'title' => esc_html__('Show button', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'header-style-2-button-link',
						'type' => 'text',
						'title' => esc_html__( 'Button Link', 'cryptox' ),
						'required' => array('header-style-2-button', 'equals', true),
						'default' => ''
					),
					array(
						'id' => 'header-style-2-button-text',
						'type' => 'text',
						'title' => esc_html__( 'Button Text', 'cryptox' ),
						'required' => array('header-style-2-button', 'equals', true),
						'default' => esc_html__('Get a Quote', 'cryptox')
					),
					array(
						'id' => 'header-style-2-show-language',
						'type' => 'switch',
						'title' => esc_html__('Show language', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => '36',
						'type' => 'info',
						'title' => esc_html__('If header style is like 3', 'cryptox'),
						'notice' => false
					),
					array(
						'id' => 'header-style-3-bg',
						'type' => 'background',
						'title' => esc_html__('Background', 'cryptox'),
						'default' => array(
							'background-color' => 'transparent',
							'background-image' => get_theme_file_uri('images/header-style-1-bg.jpg'),
							'background-size' => 'cover',
							'background-attachment' => 'fixed',
							'background-position' => 'center center',
							'background-repeat' => 'no-repeat'
						)
					),
					array(
						'id' => 'header-style-3-search',
						'type' => 'switch',
						'title' => esc_html__('Show search', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'header-style-3-button',
						'type' => 'switch',
						'title' => esc_html__('Show button', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'header-style-3-button-link',
						'type' => 'text',
						'title' => esc_html__( 'Button Link', 'cryptox' ),
						'required' => array('header-style-2-button', 'equals', true),
						'default' => ''
					),
					array(
						'id' => 'header-style-3-button-text',
						'type' => 'text',
						'title' => esc_html__( 'Button Text', 'cryptox' ),
						'required' => array('header-style-2-button', 'equals', true),
						'default' => esc_html__('Get a Quote', 'cryptox')
					),
					array(
						'id' => 'header-style-3-show-language',
						'type' => 'switch',
						'title' => esc_html__('Show language', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Header Style', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'header-style',
						'type' => 'image_select',
						'full_width' => true,
						'title' => esc_html__('Header Style', 'cryptox'),
						'options' => $header_style,
						'default' => 'style-1'
					)
				)
			);

			// Logo
			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Logo', 'cryptox'),
				'fields' => array(
					array(
						'id' => '112',
						'type' => 'info',
						'title' => esc_html__('If header type is like 1', 'cryptox'),
						'notice' => false
					),
					array(
						'id' => 'logo',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Logo', 'cryptox'),
						'default' => array(
							'url' => get_theme_file_uri('images/logo.png')
						)
					),
					array(
						'id' => 'logo_hidpi',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Logo HiDPI', 'cryptox'),
						'default' => array(
							'url' => get_theme_file_uri('images/logo@2x.png')
						)
					),
					array(
						'id' => '112',
						'type' => 'info',
						'title' => esc_html__('If header type is like 2', 'cryptox'),
						'notice' => false
					),
					array(
						'id' => 'logo_header_2',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Logo', 'cryptox'),
						'default' => array(
							'url' => get_theme_file_uri('images/logo2.png')
						)
					),
					array(
						'id' => 'logo_header_2_hidpi',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Logo HiDPI', 'cryptox'),
						'default' => array(
							'url' => get_theme_file_uri('images/logo2@2x.png')
						)
					),
					array(
						'id' => '114',
						'type' => 'info',
						'title' => esc_html__('If header type is like 3', 'cryptox'),
						'notice' => false
					),
					array(
						'id' => 'logo_header_3',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Logo', 'cryptox'),
						'default' => array(
							'url' => get_theme_file_uri('images/logo2.png')
						)
					),
					array(
						'id' => 'logo_header_3_hidpi',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Logo HiDPI', 'cryptox'),
						'default' => array(
							'url' => get_theme_file_uri('images/logo2@2x.png')
						)
					),
					array(
						'id' => '122',
						'type' => 'info',
						'title' => esc_html__('Favicon', 'cryptox'),
						'notice' => false
					),
					array(
						'id' => 'favicon',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Favicon', 'cryptox'),
						'default' => array(
							'url' => get_theme_file_uri('images/favicon.png')
						)
					),



				)
			);

			// Logo
			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('CryptoCoins Widget', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'show-crypto-widget',
						'type' => 'switch',
						'title' => esc_html__('Show CryptoCoins Widget on front page', 'cryptox'),
						'default' => false,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => "crypto-widget-symbols",
						'type' => 'text',
						'title' => esc_html__('Symbols List', 'cryptox'),
						'default' => '',
						'desc' => esc_html__( 'Enter cryptocurrency codes separated by comma (e.g. BTC,ETH,XRP)', 'cryptox' )
					)
				)
			);

			$this->sections[] = array(
				'icon' => 'el-icon-website',
				'icon_class' => 'icon',
				'title' => esc_html__('Pages & Posts', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'show-pagetitle',
						'type' => 'switch',
						'title' => esc_html__('Show Page Title', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'show-breadcrumbs',
						'type' => 'switch',
						'title' => esc_html__('Show Breadcrumbs', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Page Archive', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'post-archive-layout',
						'type' => 'image_select',
						'title' => esc_html__('Page Layout', 'cryptox'),
						'options' => $page_layouts,
						'default' => 'right-sidebar'
					),
					array(
						'id' => 'blog-archive-layout',
						'type' => 'select',
						'title' => esc_html__('Blog Layout', 'cryptox'),
						'options' => array(
							'entry-small' => esc_html__('Grid', 'cryptox'),
							'list-type' => esc_html__('List', 'cryptox')
						),
						'default' => 'entry-small',
					),
					array(
						'id' => 'blog-archive-columns',
						'type' => 'select',
						'title' => esc_html__('Archive Columns', 'cryptox'),
						'options' => cryptex_blog_columns(),
						'default' => 2,
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Blog Post', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'post-metas',
						'type' => 'button_set',
						'title' => esc_html__('Post Meta', 'cryptox'),
						'multi' => true,
						'options'=> array(
							'date' => esc_html__('Date', 'cryptox'),
							'cats' => esc_html__('Categories', 'cryptox'),
							'tags' => esc_html__('Tags', 'cryptox'),
							'-' => esc_html__('None', 'cryptox')
						),
						'default' => array( 'date','cats', 'tags', '-' )
					),
					array(
						'id' => 'blog-archive-big-post',
						'type' => 'switch',
						'title' => esc_html__('Show first post a big', 'cryptox'),
						'default' => true,
						'desc' => esc_html__('On Category Pages', 'cryptox'),
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Single Post', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'post-single-layout',
						'type' => 'image_select',
						'title' => esc_html__('Page Layout', 'cryptox'),
						'options' => $page_layouts,
						'default' => 'right-sidebar'
					),
					array(
						'id' => 'single-post-metas',
						'type' => 'button_set',
						'title' => esc_html__('Post Meta', 'cryptox'),
						'multi' => true,
						'options'=> array(
							'categories' => esc_html__('Categories', 'cryptox'),
							'date' => esc_html__('Date', 'cryptox'),
							'author' => esc_html__('Author', 'cryptox'),
							'-' => esc_html__('None', 'cryptox')
						),
						'desc' => esc_html__('Located at the top of the post', 'cryptox'),
						'default' => array( 'categories', 'date','author', '-' )
					),
					array(
						'id' => 'post-breadcrumbs',
						'type' => 'switch',
						'title' => esc_html__('Show Breadcrumbs', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'post-tag',
						'type' => 'switch',
						'title' => esc_html__('Show Tags', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'post-nav',
						'type' => 'switch',
						'title' => esc_html__('Prev/Next Navigation', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'post-related-posts',
						'type' => 'switch',
						'title' => esc_html__('Show Related Posts', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'post-comments',
						'type' => 'switch',
						'title' => esc_html__('Show Comments', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'post-ads',
						'type' => 'media',
						'url'=> true,
						'readonly' => false,
						'title' => esc_html__('Advertisement', 'cryptox'),
						'default' => array(
							'url' => ''
						)
					),
					array(
						'id' => 'post-link-ads',
						'type' => 'text',
						'title' => esc_html__('Link to ADS', 'cryptox'),
						'default' => ''
					),
				)
			);

			$this->sections[] = array(
				'icon' => 'el-icon-website',
				'icon_class' => 'icon',
				'title' => esc_html__('ICO', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'ico-archive-layout',
						'type' => 'image_select',
						'title' => esc_html__('Page Layout', 'cryptox'),
						'options' => $page_layouts,
						'default' => 'right-sidebar'
					),
					array(
						'id' => 'ico-sidebar',
						'type' => 'select',
						'title' => esc_html__('Select Sidebar', 'cryptox'),
						'required' => array( 'ico-archive-layout','equals', $sidebars ),
						'data' => 'sidebars',
						'default' => 'ico-widget-area'
					),
					array(
						'id' => 'ico-pagetitle',
						'type' => 'switch',
						'title' => esc_html__('Show Page Title', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'ico-singular-pagetitle',
						'type' => 'switch',
						'title' => esc_html__('Show Page Title', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'ico-singular-breadcrumbs',
						'type' => 'switch',
						'title' => esc_html__('Show Breadcrumbs', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Single ICO', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'ico-social-share',
						'type' => 'switch',
						'title' => esc_html__('Social Share', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'ico-nav',
						'type' => 'switch',
						'title' => esc_html__('Prev/Next Navigation', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
				)
			);

			$this->sections[] = array(
				'icon' => 'el-icon-picture',
				'icon_class' => 'icon',
				'title' => esc_html__('Portfolio', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'portfolio-archive-layout',
						'type' => 'image_select',
						'title' => esc_html__('Page Layout', 'cryptox'),
						'options' => $page_layouts,
						'default' => 'no-sidebar'
					),
					array(
						'id' => 'portfolio-related-posts',
						'type' => 'switch',
						'title' => esc_html__('Show Portfolio Related Posts', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Single Portfolio', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'portfolio-pagetitle',
						'type' => 'switch',
						'title' => esc_html__('Show Page Title', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'portfolio-breadcrumbs',
						'type' => 'switch',
						'title' => esc_html__('Show Breadcrumbs', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'portfolio-nav',
						'type' => 'switch',
						'title' => esc_html__('Prev/Next Navigation', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
				)
			);

			$this->sections[] = array(
				'icon' => 'el-icon-user',
				'icon_class' => 'icon',
				'title' => esc_html__('Team Members', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'team-members-archive-layout',
						'type' => 'image_select',
						'title' => esc_html__('Page Layout', 'cryptox'),
						'options' => $page_layouts,
						'default' => 'right-sidebar'
					),
					array(
						'id' => 'team-members-sidebar',
						'type' => 'select',
						'title' => esc_html__('Select Sidebar', 'cryptox'),
						'required' => array('team-members-archive-layout', 'equals', $sidebars),
						'data' => 'sidebars',
						'default' => 'team-members-widget-area'
					),
					array(
						'id' => 'team-members-style-single-page',
						'type' => 'button_set',
						'title' => esc_html__('Style Single Page', 'cryptox'),
						'options' => array(
							'style-1' => esc_html__('Classic', 'cryptox'),
							'style-2' => esc_html__('Tabs', 'cryptox'),
						),
						'default' => 'style-1',
						'desc' => esc_html__( 'Select style for team member single page', 'cryptox' )
					),
					array(
						'id' => 'team-members-archive-count',
						'type' => 'text',
						'title' => esc_html__('Posts Per Page', 'cryptox'),
						'default' => '10'
					),
					array(
						'id' => 'team-members-pagetitle',
						'type' => 'switch',
						'title' => esc_html__('Show Page Title', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'team-members-singular-pagetitle',
						'type' => 'switch',
						'title' => esc_html__('Show Page Title', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'team-members-singular-breadcrumbs',
						'type' => 'switch',
						'title' => esc_html__('Show Breadcrumbs', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
				)
			);

			$this->sections[] = array(
				'icon' => 'el-icon-quotes',
				'icon_class' => 'icon',
				'title' => esc_html__('Testimonials', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'testimonials-archive-count',
						'type' => 'text',
						'title' => esc_html__('Posts Per Page', 'cryptox'),
						'default' => '10'
					),
				)
			);

			$this->sections[] = array(
				'icon' => 'el-icon-cog',
				'icon_class' => 'icon',
				'title' => esc_html__('Services', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'services-page-layout',
						'type' => 'image_select',
						'title' => esc_html__('Page Layout', 'cryptox'),
						'options' => $page_layouts,
						'default' => 'no-sidebar'
					),
					array(
						'id' => 'services-pagetitle',
						'type' => 'switch',
						'title' => esc_html__('Show Page Title', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'services-singular-pagetitle',
						'type' => 'switch',
						'title' => esc_html__('Show Page Title', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'services-singular-breadcrumbs',
						'type' => 'switch',
						'title' => esc_html__('Show Breadcrumbs', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
				)
			);

			$this->sections[] = array(
				'icon' => 'el-icon-cog',
				'icon_class' => 'icon',
				'title' => esc_html__('Events', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'events-page-layout',
						'type' => 'image_select',
						'title' => esc_html__('Page Layout', 'cryptox'),
						'options' => $page_layouts,
						'default' => 'no-sidebar'
					),
					array(
						'id' => 'events-pagetitle',
						'type' => 'switch',
						'title' => esc_html__('Show Page Title', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'events-breadcrumbs',
						'type' => 'switch',
						'title' => esc_html__('Show Breadcrumbs', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Single Event', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'events-singular-pagetitle',
						'type' => 'switch',
						'title' => esc_html__('Show Page Title', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'events-singular-breadcrumbs',
						'type' => 'switch',
						'title' => esc_html__('Show Breadcrumbs', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
				)
			);

			// Shop
			$this->sections[] = array(
				'icon' => 'el-icon-shopping-cart',
				'icon_class' => 'icon',
				'title' => esc_html__('Shop', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'product-pagetitle',
						'type' => 'switch',
						'title' => esc_html__('Show Page Title', 'cryptox'),
						'default' => false,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'product-breadcrumbs',
						'type' => 'switch',
						'title' => esc_html__('Show Breadcrumbs', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'product-sale',
						'type' => 'switch',
						'title' => esc_html__('Show "Sale" Status', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'product-new',
						'type' => 'switch',
						'title' => esc_html__('Show "New" Status', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),

				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Product Archives', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'product-archive-layout',
						'type' => 'image_select',
						'title' => esc_html__('Page Layout', 'cryptox'),
						'options' => $page_layouts,
						'default' => 'left-sidebar'
					),
					array(
						'id' => 'product-sidebar',
						'type' => 'select',
						'title' => esc_html__('Select Sidebar', 'cryptox'),
						'required' => array( 'product-archive-layout','equals', $sidebars ),
						'data' => 'sidebars',
						'default' => 'shop-widget-area'
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Single Product', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'product-single-layout',
						'type' => 'image_select',
						'title' => esc_html__('Single Layout', 'cryptox'),
						'options' => $page_layouts,
						'default' => 'right-sidebar'
					),
					array(
						'id' => 'product-upsells',
						'type' => 'switch',
						'title' => esc_html__('Show Up-Sells', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'product-upsells-count',
						'type' => 'text',
						'required' => array('product-upsells','equals',true),
						'title' => esc_html__('Up-Sells Count items', 'cryptox'),
						'default' => 3
					),
					array(
						'id' => 'product-upsells-cols',
						'type' => 'button_set',
						'required' => array( 'product-upsells','equals',true ),
						'title' => esc_html__('Up-Sells Product Columns', 'cryptox'),
						'options' => cryptex_product_columns(),
						'default' => 3,
					),
					array(
						'id' => 'product-related-cols',
						'type' => 'button_set',
						'title' => esc_html__('Related Product Columns', 'cryptox'),
						'options' => cryptex_product_columns(),
						'default' => 3,
					),
					array(
						'id' => '31',
						'type' => 'info',
						'title' => esc_html__('Social Links', 'cryptox'),
						'notice' => false
					),
					array(
						'id' => 'product-single-share',
						'type' => 'switch',
						'title' => esc_html__('Show Social Links', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'product-share-facebook',
						'type' => 'switch',
						'title' => esc_html__('Enable Facebook Share', 'cryptox'),
						'required' => array('product-single-share','equals',true),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'product-share-twitter',
						'type' => 'switch',
						'title' => esc_html__('Enable Twitter Share', 'cryptox'),
						'required' => array('product-single-share','equals',true),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'product-share-googleplus',
						'type' => 'switch',
						'title' => esc_html__('Enable Google Plus Share', 'cryptox'),
						'required' => array('product-single-share','equals',true),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'product-share-pinterest',
						'type' => 'switch',
						'title' => esc_html__('Enable Pinterest Share', 'cryptox'),
						'required' => array('product-single-share','equals',true),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'product-share-email',
						'type' => 'switch',
						'title' => esc_html__('Enable Email Share', 'cryptox'),
						'required' => array('product-single-share','equals',true),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
				)
			);

			$this->sections[] = array(
				'icon_class' => 'icon',
				'subsection' => true,
				'title' => esc_html__('Cart', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'product-crosssell',
						'type' => 'switch',
						'title' => esc_html__('Show Cross-Sells', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'product-crosssell-columns',
						'type' => 'text',
						'required' => array( 'product-crosssell','equals',true ),
						'title' => esc_html__('Cross Sells Columns', 'cryptox'),
						'default' => '3'
					),
					array(
						'id' => 'product-crosssell-count',
						'type' => 'text',
						'required' => array( 'product-crosssell','equals',true ),
						'title' => esc_html__('Cross Sells Limit', 'cryptox'),
						'default' => '3'
					),
				)
			);

			// Javascript Code
			$this->sections[] = array(
				'icon_class' => 'el-icon-edit',
				'title' => esc_html__('Javascript Code', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'js-code-head',
						'type' => 'ace_editor',
						'title' => esc_html__('Javascript Code Before &lt;/head&gt;', 'cryptox'),
						'subtitle' => esc_html__('Paste your JS code here.', 'cryptox'),
						'mode' => 'javascript',
						'theme' => 'monokai',
						'default' => '',
						'options' => array(
							'minLines' => 35
						)
					)
				)
			);

			// Footer Settings
			$this->sections[] = array(
				'icon' => 'el-icon-website',
				'icon_class' => 'icon',
				'title' => esc_html__('Footer', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'show-top-footer',
						'type' => 'switch',
						'title' => esc_html__('Show Top Footer', 'cryptox'),
						'default' => false,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => '205',
						'type' => 'info',
						'title' => esc_html__('Copyright', 'cryptox'),
						'notice' => false
					),
					array(
						'id' => 'show-footer-copyright',
						'type' => 'switch',
						'title' => esc_html__('Show Copyright', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => 'footer-copyright-style',
						'type' => 'button_set',
						'title' => esc_html__('Style', 'cryptox'),
						'options' => array(
							'style-1' => esc_html__('Default', 'cryptox'),
							'style-2' => esc_html__('With social links', 'cryptox'),
						),
						'default' => 'style-1'
					),
					array(
						'id' => 'footer-copyright',
						'type' => 'textarea',
						'title' => esc_html__('Copyright', 'cryptox'),
						'default' => sprintf( __('Copyright &copy; %s <a href="%s">%s</a>. All Rights Reserved.', 'cryptox'), date('Y'), home_url('/'), get_bloginfo('blogname') )
					),
					array(
						'id' => '2335',
						'type' => 'info',
						'title' => esc_html__('Social Links', 'cryptox'),
						'notice' => false
					),
					array(
						'id' => 'show-footer-social-links',
						'type' => 'switch',
						'title' => esc_html__('Show Social Links', 'cryptox'),
						'default' => true,
						'on' => esc_html__('Yes', 'cryptox'),
						'off' => esc_html__('No', 'cryptox'),
					),
					array(
						'id' => "footer-social-facebook",
						'type' => 'text',
						'title' => esc_html__('Facebook', 'cryptox'),
						'required' => array('show-footer-social-links', 'equals', true),
						'default' => '#'
					),
					array(
						'id' => "footer-social-twitter",
						'type' => 'text',
						'title' => esc_html__('Twitter', 'cryptox'),
						'required' => array('show-footer-social-links', 'equals', true),
						'default' => '#'
					),
					array(
						'id' => "footer-social-googleplus",
						'type' => 'text',
						'title' => esc_html__('Google Plus', 'cryptox'),
						'required' => array('show-footer-social-links', 'equals', true),
						'default' => '#'
					),
					array(
						'id' => "footer-social-linkedin",
						'type' => 'text',
						'title' => esc_html__('LinkedIn', 'cryptox'),
						'required' => array('show-footer-social-links', 'equals', true),
						'default' => '#'
					),
				)
			);

			$wysija_forms = array();

			if ( defined('WYSIJA') ) {
				$model_forms = WYSIJA::get( 'forms', 'model' );
				$model_forms->reset();
				$forms = $model_forms->getRows( array( 'form_id', 'name' ) );
				if ( $forms ) {
					foreach( $forms as $form ) {
						if ( isset($form) )
							$wysija_forms[$form['form_id']] = $form['name'];
					}
				}
			}

			// 404 Page
			$this->sections[] = array(
				'icon' => 'el-icon-error',
				'icon_class' => 'icon',
				'title' => esc_html__('404 Page', 'cryptox'),
				'fields' => array(
					array(
						'id' => 'error-content',
						'type' => 'textarea',
						'title' => esc_html__('Error text', 'cryptox'),
						'validate' => 'html_custom',
						'default' => '<h1 class="title">404</h1><h5 class="sub-title">We\'re sorry, but we can\'t find the page you were looking for.</h5><p>It\'s probably some thing we\'ve done wrong but now we know about it and we\'ll try to fix it.</p>',
						'allowed_html' => array(
							'h1' => array(
								'class' => array()
							),
							'h2' => array(
								'class' => array()
							),
							'h3' => array(
								'class' => array()
							),
							'h4' => array(
								'class' => array()
							),
							'h5' => array(
								'class' => array()
							),
							'p' => array(),
							'a' => array(
								'href' => array(),
								'title' => array()
							),
							'br' => array(),
							'em' => array(),
							'strong' => array()
						)
					),
				)
			);

			// Google
			$this->sections[] = array(
				'icon' => 'el-googleplus',
				'icon_class' => 'el',
				'title' => esc_html__('Google', 'cryptox'),
				'fields' => array(
					array(
						'id' => '1',
						'type' => 'info',
						'style' => 'normal',
						'title' => esc_html__('Google recently changed the way their map service works. New pages which want to use Google Maps need to register an API key for their website. Older pages should  work fine without this API key. If the google map elements of this theme do not work properly you need to register a new API key.', 'cryptox'),
						'notice' => false
					),
					array(
						'id' => 'gmap-api',
						'type' => 'textarea',
						'title' => esc_html__('Google Maps API Key', 'cryptox'),
						'desc' => esc_html__('Enter a valid Google Maps API Key to use all map related theme functions.', 'cryptox'),
						'default' => ''
					),
				)
			);

		}

		public function setArguments() {

			$theme = $this->theme;

			$this->args = array(
				'opt_name'          => 'cryptex_settings',
				'display_name'      => $theme->get('Name') . ' ' . esc_html__('Theme Options', 'cryptox'),
				'display_version'   => esc_html__('Theme Version: ', 'cryptox') . strtolower($theme->get('Version')),
				'menu_type'         => 'submenu',
				'allow_sub_menu'    => true,
				'menu_title'        => esc_html__('Theme Options', 'cryptox'),
				'page_title'        => esc_html__('Theme Options', 'cryptox'),
				'footer_credit'     => esc_html__('Theme Options', 'cryptox'),

				'google_api_key' => 'AIzaSyBQft4vTUGW75YPU6c0xOMwLKhxCEJDPwg',
				'disable_google_fonts_link' => true,

				'async_typography'  => false,
				'admin_bar'         => false,
				'admin_bar_icon'       => 'dashicons-admin-generic',
				'admin_bar_priority'   => 50,
				'global_variable'   => '',
				'dev_mode'          => false,
				'customizer'        => false,
				'compiler'          => false,

				'page_priority'     => null,
				'page_parent'       => 'themes.php',
				'page_permissions'  => 'manage_options',
				'menu_icon'         => '',
				'last_tab'          => '',
				'page_icon'         => 'icon-themes',
				'page_slug'         => 'cryptex_settings',
				'save_defaults'     => true,
				'default_show'      => false,
				'default_mark'      => '',
				'show_import_export' => true,
				'show_options_object' => false,

				'transient_time'    => 60 * MINUTE_IN_SECONDS,
				'output'            => false,
				'output_tag'        => false,

				'database'              => '',
				'system_info'           => false,

				'hints' => array(
					'icon'          => 'icon-question-sign',
					'icon_position' => 'right',
					'icon_color'    => 'lightgray',
					'icon_size'     => 'normal',
					'tip_style'     => array(
						'color'         => 'light',
						'shadow'        => true,
						'rounded'       => false,
						'style'         => '',
					),
					'tip_position'  => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect'    => array(
						'show'          => array(
							'effect'        => 'slide',
							'duration'      => '500',
							'event'         => 'mouseover',
						),
						'hide'      => array(
							'effect'    => 'slide',
							'duration'  => '500',
							'event'     => 'click mouseleave',
						),
					),
				),
				'ajax_save'                 => false,
				'use_cdn'                   => true,
			);

		}

	}

	global $cryptex_redux_settings;
	$cryptex_redux_settings = new cryptex_redux_settings();

}