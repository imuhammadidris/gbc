<?php

class WPBakeryShortCode_VC_mad_contact_info extends WPBakeryShortCode {

	public $atts = array();
	public $content = '';

	protected function content( $atts, $content = null ) {

		$this->atts = shortcode_atts(array(
			'title' => '',
			'heading' => 'h3',
			'info_location' => '',
			'info_phone' => '',
			'info_fax' => '',
			'info_email' => '',
			'info_open_hours' => '',
		), $atts, 'vc_mad_contact_info');

		return $this->html();
	}

	public function html() {

		$title = $info_location = $info_phone = $info_fax = $info_open_hours = '';

		extract( $this->atts );

		ob_start(); ?>

		<div class="cr-contact-holder">

			<?php
			echo Cryptex_Vc_Config::getParamTitle(
				array(
					'title' => $title,
					'heading' => $heading
				)
			);
			?>

			<div class="our-info var2">

				<?php if ( !empty($info_location) ): ?>

					<div class="info-item">
						<i class="licon-map-marker"></i>
						<p><?php echo esc_html($info_location) ?></p>
						<a href="https://www.google.com/maps/dir//<?php echo esc_url($info_location) ?>" class="link-text"><?php esc_html_e('Get Direction', 'cryptox') ?></a>
					</div>

				<?php endif; ?>

				<?php if ( !empty($info_phone) ): ?>

					<div class="info-item">
						<i class="licon-telephone"></i>
						<p content="telephone=no"><?php echo esc_html($info_phone) ?></p>
					</div>

				<?php endif; ?>

				<?php if ( !empty($info_email) ): ?>

					<div class="info-item">
						<i class="licon-at-sign"></i>
						<p><a href="mailto:<?php echo antispambot($info_email, 1) ?>"><?php echo esc_html($info_email) ?></a></p>
					</div>

				<?php endif; ?>

				<?php if ( !empty($info_open_hours) ): ?>

					<div class="info-item">
						<i class="licon-clock3"></i>
						<p><?php echo esc_html($info_open_hours) ?></p>
					</div>

				<?php endif; ?>

			</div>

		</div>

		<?php return ob_get_clean();
	}

}