<?php
if (!class_exists('cryptex_info_block')) {

	class cryptex_info_block
	{

		function __construct()
		{
			add_action('vc_before_init', array($this, 'add_map'));
		}

		function add_map() {

			if ( function_exists('vc_map') ) {

				vc_map(
					array(
						"name" => esc_html__('Infoblock', 'cryptox'),
						"base" => 'vc_mad_info_block',
						"class" => 'vc_mad_info_block',
						"icon" => "icon-wpb-mad-info-block",
						"category" => esc_html__('Cryptex', 'cryptox'),
						"description" => esc_html__('Styled info blocks', 'cryptox'),
						"as_parent" => array('only' => 'vc_mad_info_block_item'),
						"content_element" => true,
						"show_settings_on_create" => false,
						"params" => array(
							array(
								'type' => 'textfield',
								'heading' => esc_html__( 'Title', 'cryptox' ),
								'param_name' => 'title',
								'description' => esc_html__( 'Enter text which will be used as title. Leave blank if no title is needed.', 'cryptox' ),
							),
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Tag', 'cryptox'),
								'param_name' => 'heading',
								'value' => array(
									'h2' => 'h2',
									'h3' => 'h3',
									'h4' => 'h4'
								),
								'std' => 'h3',
								'description' => esc_html__('Choose tag for heading', 'cryptox'),
								'param_holder_class' => ''
							),
							array(
								'type' => 'textfield',
								'heading' => esc_html__( 'Subtitle', 'cryptox' ),
								'param_name' => 'subtitle',
								'description' => esc_html__( 'Enter text which will be used as subtitle. Leave blank if no subtitle is needed.', 'cryptox' )
							),
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Title Alignment', 'cryptox'),
								'param_name' => 'align_title',
								'description' => esc_html__('Select title alignment.', 'cryptox'),
								'value' => array(
									esc_html__('Left', 'cryptox') => 'align-left',
									esc_html__('Right', 'cryptox') => 'align-right',
									esc_html__('Center', 'cryptox') => 'align-center'
								),
							),
							array(
								"type" => "dropdown",
								"heading" => esc_html__( 'Select type', 'cryptox' ),
								"param_name" => 'style',
								"value" => array(
									esc_html__('Style 1', 'cryptox') => 'style-1',
									esc_html__('Style 2', 'cryptox') => 'style-2',
									esc_html__('Style 3', 'cryptox') => 'style-3',
									esc_html__('Style 4', 'cryptox') => 'style-4'
								),
								"std" => 'style-1',
								"description" => esc_html__( 'Choose type for this info block.', 'cryptox' )
							),
							array(
								'type' => 'dropdown',
								'heading' => esc_html__( 'Columns', 'cryptox' ),
								'param_name' => 'columns',
								'value' => array(
									2 => 2,
									3 => 3,
									4 => 4
								),
								'std' => 3,
								'description' => esc_html__('Choose count columns.', 'cryptox')
							),
						),
						"js_view" => 'VcColumnView'
					));

				vc_map(
					array(
						"name" => esc_html__("Info Block Item", 'cryptox'),
						"base" => "vc_mad_info_block_item",
						"class" => "vc_mad_info_block_item",
						"icon" => "icon-wpb-mad-info-block",
						"category" => esc_html__('Infoblock', 'cryptox'),
						"content_element" => true,
						"as_child" => array('only' => 'vc_mad_info_block'),
						"is_container" => true,
						"params" => array(
							array(
								"type" => "textfield",
								"heading" => esc_html__('Title', 'cryptox'),
								"param_name" => "title",
								"holder" => "h4",
								"description" => ''
							),
							array(
								"type" => "choose_icons",
								"heading" => esc_html__("Icon", 'cryptox'),
								"param_name" => "icon",
								"value" => 'none',
								"description" => esc_html__( 'Select icon from library.', 'cryptox')
							),
							array(
								'type' => 'attach_image',
								'heading' => esc_html__('Image', 'cryptox'),
								'param_name' => 'image',
								'value' => '',
								'description' => esc_html__('Select image from media library.', 'cryptox')
							),
							array(
								'type' => 'textarea_html',
								'holder' => 'div',
								'heading' => esc_html__('Text', 'cryptox'),
								'param_name' => 'content',
								'value' => wp_kses(__('<p>Click edit button to change this text.</p>', 'cryptox'), array('p' => array()))
							),
							array(
								'type' => 'vc_link',
								'heading' => esc_html__('URL (Link)', 'cryptox'),
								'param_name' => 'link',
								'description' => esc_html__('Add link to info block.', 'cryptox'),
							),
							array(
								'type' => 'colorpicker',
								'heading' => esc_html__( 'Color', 'cryptox' ),
								'param_name' => 'color',
								'group' => esc_html__( 'Styling', 'cryptox' ),
								'edit_field_class' => 'vc_col-sm-6',
								'description' => esc_html__( 'Select custom color for text.', 'cryptox' ),
							),
						)
					)
				);

			}
		}

	}

	if (class_exists('WPBakeryShortCodesContainer')) {

		class WPBakeryShortCode_vc_mad_info_block extends WPBakeryShortCodesContainer
		{

			protected function content( $atts, $content = null ) {

				$style = $layout = $columns = '';

				extract( shortcode_atts( array(
					'title' => '',
					'subtitle' => '',
					'heading' => 'h3',
					'align_title' => 'align-left',
					'columns' => 3,
					'style' => 'style-1'
				), $atts ) );

				$css_class = array(
					'icons-box',
					$style,
					'cols-' . $columns
				);

				global $vc_mad_info_block_args;
				$vc_mad_info_block_args[] = array(
					'style' => $style,
					'content' => $content
				);

				ob_start(); ?>

				<?php
				echo Cryptex_Vc_Config::getParamTitle(
					array(
						'title' => $title,
						'subtitle' => $subtitle,
						'heading' => $heading,
						'align_title' => $align_title
					)
				);

				?>

				<div class="<?php echo esc_attr(implode(' ', $css_class)); ?>">
					<?php echo wpb_js_remove_wpautop( $content, false ) ?>
				</div><!--/ .icons-box-->

				<?php return ob_get_clean();

			}

		}

		class WPBakeryShortCode_vc_mad_info_block_item extends WPBakeryShortCode
		{

			protected function content( $atts, $content = null ) 	{

				$title = $link = $style_color = $image = $style = '';

				extract( shortcode_atts(array(
					'title' => '',
					'icon' => '',
					'image' => '',
					'link' => '',
					'color' => ''
				), $atts) );

				$link = ($link == '||') ? '' : $link;
				$link = vc_build_link($link);
				$a_href = $link['url'];
				$a_title = $link['title'];
				( $link['target'] != '' ) ? $a_target = $link['target'] : $a_target = '_self';

				global $vc_mad_info_block_args;

				if ( isset($vc_mad_info_block_args) && is_array($vc_mad_info_block_args) ) {
					foreach ( $vc_mad_info_block_args as $info_block ) {
							if ( isset($info_block['style']) && !empty($info_block['style']) ) {
								$style = $info_block['style'];
							}
					}
				}

				if ( $content == null ) $content = '';

				if ( !empty($color) ) {
					$style_color = 'style="' . vc_get_css_color( 'color', $color ) . '"';
				}

				ob_start(); ?>

				<div class="icons-wrap" <?php if ( $style == 'style-3' && $image && absint($image) ): ?> data-bg="<?php echo esc_url(wp_get_attachment_image_url($image, 'cryptex-660x415-center-center')) ?>" <?php endif; ?> >

					<div class="icons-item" <?php echo "{$style_color}" ?>>

						<?php if ( $style == 'style-4' ): ?>

							<?php if ( $image && absint($image)): ?>

								<div class="box-img">
									<?php echo wp_get_attachment_image( $image, '' ); ?>
								</div>

							<?php endif; ?>

						<?php endif; ?>

						<div class="item-box">

							<?php if ( $style != 'style-4' ): ?>
								<?php if ( $icon != '' ): ?>
									<i class="licon <?php echo esc_attr($icon) ?>"></i>
								<?php endif; ?>
							<?php endif; ?>

							<?php if ( !empty($title) ): ?>
								<h5 class="icons-box-title">
									<a href="<?php if ( !empty($a_href) ): ?><?php echo esc_url($a_href) ?><?php endif; ?>"><?php echo esc_html($title) ?></a>
								</h5>
							<?php endif; ?>

							<?php if ( $style == 'style-3' ): ?> <div class="hidden-area"> <?php endif; ?>

								<?php if ( !empty($content) ): ?>
									<?php echo wpb_js_remove_wpautop( $content, true ) ?>
								<?php endif; ?>

								<?php if ( !empty($a_href) ): ?>
									<a href="<?php echo esc_url($a_href) ?>" class="btn">
										<?php echo esc_html($a_title) ?>
									</a>
								<?php endif; ?>

							<?php if ( $style == 'style-3' ): ?> </div> <?php endif; ?>

						</div><!--/ .item-box-->

					</div><!--/ .icons-item-->

				</div><!--/ .icons-wrap-->

				<?php return ob_get_clean();
			}

		}

	}

	new cryptex_info_block();
}