<?php

class WPBakeryShortCode_VC_mad_list_styles extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'values' => '',
			'color' => ''
		), $atts, 'vc_mad_list_styles');

		return $this->html();
	}

	public function html() {

	 	$icon = $list_items = $list_styles = $values = $color = '';

		extract( $this->atts );

		$values = (array) vc_param_group_parse_atts( $values );

		ob_start(); ?>

		<?php if ( !empty($values) ): ?>

			<ul class="custom-shortcode">

				<?php foreach ( $values as $value ): ?>

					<li>

						<?php if ( isset($value['icon']) ): ?>

							<?php $icon = trim($value['icon']); ?>

							<?php if ( !empty($icon) && $icon !== 'none' ): ?>
								<i class="<?php echo trim($icon) ?>"></i>
							<?php endif; ?>

						<?php endif; ?>

						<?php echo esc_html($value['label']) ?>

					</li>

				<?php endforeach; ?>

			</ul><!--/ .custom-list-->

		<?php endif; ?>

		<?php return ob_get_clean();
	}

}