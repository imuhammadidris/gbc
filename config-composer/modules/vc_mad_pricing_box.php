<?php
if ( !class_exists('cryptex_pricing_box') ) {

	class cryptex_pricing_box {

		function __construct() {
			add_action('vc_before_init', array($this, 'add_map_pricing_box'));
		}
		
		function add_map_pricing_box() {

			if ( function_exists('vc_map') ) {

				vc_map(
					array(
					   "name" => esc_html__("Pricing Box", 'cryptox' ),
					   "base" => "vc_mad_pricing_box",
					   "class" => "vc_mad_pricing_box",
					   "icon" => "icon-wpb-mad-pricing-box",
					   "category"  => esc_html__('Cryptex', 'cryptox'),
					   "description" => esc_html__('Styled pricing tables', 'cryptox'),
					   "as_parent" => array('only' => 'vc_mad_pricing_box_item'),
					   "content_element" => true,
					   "show_settings_on_create" => true,
					   "params" => array(
						   array(
							   'type' => 'textfield',
							   'heading' => esc_html__( 'Title', 'cryptox' ),
							   'param_name' => 'title',
							   'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
						   ),
						   array(
							   'type' => 'colorpicker',
							   'heading' => esc_html__( 'Color for title', 'cryptox' ),
							   'param_name' => 'title_color',
							   'group' => esc_html__( 'Styling', 'cryptox' ),
							   'edit_field_class' => 'vc_col-sm-6',
							   'description' => esc_html__( 'Select custom color for title.', 'cryptox' ),
						   ),
						),
						"js_view" => 'VcColumnView'
					));

				vc_map(
					array(
					   "name" => esc_html__("Pricing Box Item", 'cryptox'),
					   "base" => "vc_mad_pricing_box_item",
					   "class" => "vc_mad_pricing_box_item",
					   "icon" => "icon-wpb-mad-pricing-box",
					   "category" => esc_html__('Pricing Box', 'cryptox'),
					   "content_element" => true,
					   "as_child" => array('only' => 'vc_mad_pricing_box'),
					   "is_container" => false,
					   "params" => array(
						   array(
							   "type" => "textfield",
							   "heading" => esc_html__( 'Package Name / Title', 'cryptox' ),
							   "param_name" => "title",
							   "holder" => "h4",
							   "description" => esc_html__( 'Enter the package name or table heading.', 'cryptox' ),
							   "value" => '',
						   ),
						   array(
							   "type" => "textfield",
							   "heading" => esc_html__( 'Package Price', 'cryptox' ),
							   "param_name" => "price",
							   "holder" => "span",
							   "description" => esc_html__( 'Enter the price for this package', 'cryptox' ),
							   "value" => ''
						   ),
						   array(
							   "type" => "textfield",
							   "heading" => esc_html__( 'Price Unit', 'cryptox' ),
							   "param_name" => "time",
							   "holder" => "span",
							   "description" => esc_html__( 'Enter the price unit for this package. e.g. per month', 'cryptox' ),
							   "value" => esc_html__( 'per month', 'cryptox' )
						   ),
						   array(
							   "type" => "textarea",
							   "heading" => esc_html__( 'Features', 'cryptox' ),
							   "param_name" => "features",
							   "holder" => "span",
							   "description" => esc_html__( 'Create the features list using un-ordered list elements. Divide values with linebreaks (Enter). Example: Up to 50 users|Limited team members', 'cryptox' ),
							   "value" => esc_html__('Vestibulum sed | Donec sagittis euismod | Sed ut perspiciatis | Unde omnis iste | Natus error sit', 'cryptox')
						   ),
						   array(
							   "type" => "vc_link",
							   "heading" => esc_html__( 'Add URL to the whole box (optional)', 'cryptox' ),
							   "param_name" => "link",
						   ),
						   array(
							   'type' => 'checkbox',
							   'heading' => esc_html__( 'Featured', 'cryptox' ),
							   'param_name' => 'add_label',
							   'description' => esc_html__( 'Adds a nice label to your pricing box.', 'cryptox' ),
							   'value' => array( esc_html__( 'Yes, please', 'cryptox' ) => true )
						   ),
						   array(
							   'type' => 'colorpicker',
							   'heading' => esc_html__( 'Background Color', 'cryptox' ),
							   'param_name' => 'bg_color',
							   'group' => esc_html__( 'Styling', 'cryptox' ),
							   'description' => esc_html__( 'Select custom background color.', 'cryptox' ),
						   ),
					    )
					)
				);

			}
		}

	}

	if ( class_exists('WPBakeryShortCodesContainer') ) {

		class WPBakeryShortCode_vc_mad_pricing_box extends WPBakeryShortCodesContainer {

			protected function content($atts, $content = null) {

				$tag_title = $description = $title_color = $description_color = $layout = $spacing = $columns = '';

				extract( shortcode_atts(array(
					'title' => '',
					'heading' => 'h2',
					'title_color' => '',
					'align_title' => '',
//					'spacing' => 'kw-with-spacing',
//					'columns' => 3
				), $atts ) );

				$title = !empty($atts['title']) ? $atts['title'] : '';
//				$subtitle = !empty($atts['subtitle']) ? $atts['subtitle'] : '';
				$heading = !empty($atts['heading']) ? $atts['heading'] : '';
				$title_color = !empty($atts['title_color']) ? $atts['title_color'] : '';
//				$subtitle_color = !empty($atts['subtitle_color']) ? $atts['subtitle_color'] : '';
				$align_title = !empty($atts['align_title']) ? $atts['align_title'] : '';

				$css_class = array(
					'pricing-tables-holder', 'cols-4'
				);

				ob_start(); ?>

				<?php
				echo Cryptex_Vc_Config::getParamTitle(
					array(
						'title' => $title,
//						'subtitle' => $subtitle,
//						'heading' => $heading,
//						'title_color' => $title_color,
//						'subtitle_color' => $subtitle_color,
//						'align_title' => $align_title
					)
				);
				?>

				<div class="<?php echo esc_attr( implode(' ', $css_class) ); ?>">
					<?php echo wpb_js_remove_wpautop( $content, false ) ?>
				</div>

				<?php return ob_get_clean() ;
			}

		}

		class WPBakeryShortCode_vc_mad_pricing_box_item extends WPBakeryShortCode {

			protected function content($atts, $content = null) {
				$title = $price = $time = $features = $add_label = $link = "";

				extract( shortcode_atts(array(
					'title' => esc_html__('Free', 'cryptox'),
					'price' => '',
					'time' => esc_html__('per month', 'cryptox'),
					'features' => '',
					'link' => '',
					'bg_color' => '',
					'add_label' => false,
				),$atts) );

				$link = ($link == '||') ? '' : $link;
				$link = vc_build_link($link);
				$a_href = $link['url'];
				$a_title = $link['title'];
				( $link['target'] != '' ) ? $a_target = $link['target'] : $a_target = '_self';

				$style_bg_color = '';
				$bg_color = !empty($atts['bg_color']) ? $atts['bg_color'] : '';

				if ( !empty($bg_color) ) {
					$style_bg_color = 'style="' . vc_get_css_color( 'background-color', $bg_color ) . '"';
				}

				$wrapper_attributes = array();
				$css_classes = array( 'pricing-col' );

				$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
				$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

				ob_start(); ?>

				<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

					<div <?php echo "{$style_bg_color}" ?> class="pricing-table <?php if ( $add_label ): ?>selected<?php endif; ?>">

						<?php if ( $add_label ): ?>
							<div class="label"><?php esc_html_e('Recommended', 'cryptox') ?></div>
						<?php endif; ?>

						<header class="pt-header">
							<div class="pt-type"><?php echo esc_html($title); ?></div>
							<div class="pt-price"><?php echo esc_html($price); ?></div>
							<div class="pt-period"><?php echo esc_html($time) ?></div>
						</header><!--/ .pt-header -->

						<ul class="custom-list">
							<?php
							$features = explode( '|', wp_strip_all_tags($features) );
							$feature_list = '';
							if ( is_array($features) ) {
								foreach ( $features as $feature ) {
									$feature_list .= "<li>{$feature}</li>";
								}
							}
							?>
							<?php echo wp_kses( $feature_list, array(
								'a' => array(
									'href' => true,
									'title' => true,
								),
								'li' => array()
							)); ?>
						</ul>

						<?php if ( !empty($a_title) ): ?>
							<footer class="pt-footer">
								<a href="<?php echo esc_url($a_href); ?>" title="<?php echo esc_attr($a_title) ?>" target="<?php echo esc_attr($a_target) ?>" class="btn btn-style-4"><?php echo esc_html($a_title); ?></a>
							</footer>
						<?php endif; ?>

					</div><!--/ .pricing-table-->

				</div><!--/ .pricing-col-->

				<?php return ob_get_clean() ;
			}

		}
	}

	new cryptex_pricing_box();

}