<?php

class WPBakeryShortCode_VC_mad_mailpoet extends WPBakeryShortCode {

	public $atts = array();

	protected function content($atts, $content = null) {

		$this->atts = shortcode_atts(array(
			'subheading' => '',
			'select_form' => '1',
		), $atts, 'vc_mad_mailpoet');

		$html = $this->html();

		return $html;
	}

	public function html() {

		$atts = $this->atts;

		ob_start();

		if ( !empty($atts['p']) ) {
			echo wp_kses( $this->getHeading( 'p', $atts ), array(
				'p' => array()
			));
		}

		if ( !empty($atts['select_form']) ) {
			echo sprintf('%s', $this->getForm( $atts ));
		}

		return '<div class="newsletter-wrap">'. ob_get_clean() .'</div>';
	}

	public function getHeading( $tag, $atts ) {
		if ( isset( $atts[ $tag ] ) && '' !== trim( $atts[ $tag ] ) ) {
			return '<' . $tag . '>' . $atts[$tag] . '</' . $tag . '>';
		}
		return '';
	}

	public function getForm( $atts ) {

		$form = $data = '';

		if ( defined('WYSIJA') ) {

			if ( absint($atts['select_form']) ) {

				$form_id_real = 'form-' . absint($atts['select_form']);
				$model_forms = WYSIJA::get('forms', 'model');
				$form = $model_forms->getOne(array('form_id' => (int)$atts['select_form']));

				if ( !empty($form) ) {
					$helper_form_engine = WYSIJA::get('form_engine', 'helper');
					$helper_form_engine->set_data( $form['data'], true );

					// get html rendering of form
					$form_html = $helper_form_engine->render_web();
					remove_shortcode('user'); remove_shortcode('user_list'); remove_shortcode('list_ids'); remove_shortcode('list_id'); remove_shortcode('firstname');
					remove_shortcode('lastname'); remove_shortcode('email'); remove_shortcode('custom'); remove_shortcode('required'); remove_shortcode('field');

					// interpret shortcodes
					$form_html = do_shortcode($form_html);
					$data .= '<form id="'. $form_id_real .'" method="post" action="#wysija" class="widget_wysija">';
					$data .= $form_html;
					$data .= '</form>';

					$form = $data;
				}

			}

		} else {
			$form = '<h6>'. esc_html__('Please install required plugin - MailPoet Newsletters', 'cryptox') .'</h6>';
		}

		return $form;
	}

}