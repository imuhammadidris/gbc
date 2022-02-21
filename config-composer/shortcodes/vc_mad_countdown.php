<?php
/**
* Countdown
*/
class WPBakeryShortCode_VC_mad_countdown extends WPBakeryShortCode {

    protected function content($atts, $content = null) {

        $this->atts = shortcode_atts(array(
            'title' => '',
            'datetime'=>'',
            'text_align' => '',
            'el_class' => '',
        ), $atts, 'vc_mad_countdown');

        return $this->html();
    }

    public function html() {

        $datetime = $el_class = '';

        extract( $this->atts );

        ob_start(); ?>

		<div class="countdown"
			 data-terminal-date="<?php echo esc_attr($datetime); ?>"
			 data-time-now="<?php echo str_replace('-', '/', current_time('mysql'));?>">
		</div>

        <?php return ob_get_clean();
    }

}