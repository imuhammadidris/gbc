<?php
if (!class_exists('cryptex_vc_advanced_tour')) {

	class cryptex_vc_advanced_tour {

		function __construct() {
			add_action( 'vc_before_init', array( $this, 'add_map' ), 5 );
		}

		function add_map() {

			if ( function_exists('vc_map') ) {

				vc_map( array(
					"name"    => esc_html__('Advanced Tour', 'cryptox') ,
					"base"    => 'vc_mad_tour_element',
					"category"  => esc_html__('Cryptex', 'cryptox'),
					"description" => esc_html__("Create nice looking tour.", 'cryptox'),
					'is_container' => true,
					'show_settings_on_create' => false,
					'as_parent' => array(
						'only' => 'vc_mad_tour_section',
					),
					'icon' => 'icon-wpb-mad-advanced-tour',
					'params' => array(
						array(
							'type' => 'textfield',
							'heading' => esc_html__( 'Title', 'cryptox' ),
							'param_name' => 'title',
							'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
							'edit_field_class' => 'vc_col-sm-6',
						),
						array(
							'type' => 'dropdown',
							'heading' => esc_html__( 'Style', 'cryptox' ),
							'param_name' => 'style',
							'description' => esc_html__( 'Select style.', 'cryptox' ),
							'value' => array(
								esc_html__( 'Style 1', 'cryptox' ) => 'style-1',
								esc_html__( 'Style 2', 'cryptox' ) => 'style-2',
							),
						)
					),
					'js_view' => 'VcBackendTtaTabsView',
					'custom_markup' => '
					<div class="vc_tta-container" data-vc-action="collapse">
						<div class="vc_general vc_tta vc_tta-tabs vc_tta-color-backend-tabs-white vc_tta-style-flat vc_tta-shape-rounded vc_tta-spacing-1 vc_tta-tabs-position-left vc_tta-controls-align-left">
							<div class="vc_tta-tabs-container">'
											. '<ul class="vc_tta-tabs-list">'
											. '<li class="vc_tta-tab" data-vc-tab data-vc-target-model-id="{{ model_id }}"><a href="javascript:;" data-vc-container=".vc_tta-container" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-target-model-id="{{ model_id }}" data-vc-tabs>{{ section_title }}</a></li>'
											. '</ul>
							</div>
							<div class="vc_tta-panels {{container-class}}">
							  {{ content }}
							</div>
						</div>
					</div>',
					'default_content' => '[vc_mad_tour_section title="' . sprintf( '%s %d', __( 'Section', 'cryptox' ), 1 ) . '"][/vc_mad_tour_section][vc_mad_tour_section title="' . sprintf( '%s %d', __( 'Section', 'cryptox' ), 2 ) . '"][/vc_mad_tour_section]',
					'admin_enqueue_js' => array(
						vc_asset_url( 'lib/vc_tabs/vc-tabs.min.js' ),
					)
				));

				vc_map(array(
					'name' => esc_html__( 'Section', 'cryptox' ),
					'base' => 'vc_mad_tour_section',
					'icon' => 'icon-wpb-ui-tta-section',
					'allowed_container_element' => 'vc_row',
					'is_container' => true,
					'show_settings_on_create' => false,
					'as_child' => array(
						'only' => 'vc_mad_tour_element',
					),
					'category' => esc_html__( 'Content', 'cryptox' ),
					'description' => esc_html__( 'Section for Tour.', 'cryptox' ),
					'params' => array(
						array(
							'type' => 'textfield',
							'param_name' => 'title',
							'heading' => esc_html__( 'Title', 'cryptox' ),
							'description' => esc_html__( 'Enter section title (Note: you can leave it empty).', 'cryptox' ),
						),
						array(
							'type' => 'el_id',
							'param_name' => 'tab_id',
							'settings' => array(
								'auto_generate' => true,
							),
							'heading' => esc_html__( 'Section ID', 'cryptox' ),
							'description' => esc_html__( 'Enter section ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'cryptox' ),
						),
					),
					'js_view' => 'VcBackendTtaSectionView',
					'custom_markup' => '
						<div class="vc_tta-panel-heading">
							<h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left"><a href="javascript:;" data-vc-target="[data-model-id=\'{{ model_id }}\']" data-vc-accordion data-vc-container=".vc_tta-container"><span class="vc_tta-title-text">{{ section_title }}</span><i class="vc_tta-controls-icon vc_tta-controls-icon-plus"></i></a></h4>
						</div>
						<div class="vc_tta-panel-body">
							{{ editor_controls }}
							<div class="{{ container-class }}">
							{{ content }}
							</div>
						</div>',
					'default_content' => '',
				));

			}
		}

	}

	new cryptex_vc_advanced_tour();

	if ( class_exists('WPBakeryShortCode') ) {

		class WPBakeryShortCode_VC_mad_tour_element extends WPBakeryShortCode {

			protected $controls_css_settings = 'out-tc vc_controls-content-widget';
			protected $controls_list = array( 'add', 'edit', 'clone', 'delete' );

		}

	}

	VcShortcodeAutoloader::getInstance()->includeClass( 'WPBakeryShortCode_VC_Tta_Accordion' );

	class WPBakeryShortCode_VC_mad_tour_section extends WPBakeryShortCode_VC_Tta_Accordion {
		protected $controls_css_settings = 'tc vc_control-container';
		protected $controls_list = array( 'add', 'edit', 'clone', 'delete' );
		protected $backened_editor_prepend_controls = false;

		public function getFileName() {
			return 'vc_mad_tour_section';
		}

	}

}