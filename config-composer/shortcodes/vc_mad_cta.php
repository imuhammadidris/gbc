<?php

class WPBakeryShortCode_VC_mad_cta extends WPBakeryShortCode {

	protected $template_vars = array();

	public function buildTemplate( $atts, $content ) {
		$output = array();

		$container_classes = $column_left_clases = $columns_right_classes = array();
		$output['heading'] = $this->getHeading( 'h2', $atts );
		$output['subheading'] = $this->getHeading( 'p', $atts );

		if ( ! empty( $atts['add'] ) ) {

			switch( $atts['add'] ) {
				case 'button':

					$output['actions-button'] = $this->getOneButton( $atts );

					$column_left_clases[] = 'col-lg-8 col-md-12';
					$columns_right_classes[] = 'col-lg-4 col-md-12 align-right';

					break;
				case 'form':

					$output[ 'actions-form' ] = $this->getForm( $atts );

					$column_left_clases[] = 'col-lg-5 col-md-12';
					$columns_right_classes[] = 'col-lg-7 col-md-12 align-right';

					break;
			}

		}

		$container_classes[] = $atts['add'];
		$output['container-class'] = $container_classes;
		$output['column-left-class'] = $column_left_clases;
		$output['column-right-class'] = $columns_right_classes;

		$this->template_vars = $output;
	}

	public function getHeading( $tag, $atts ) {
		$inline_css = $styling = '';
		if ( isset( $atts[ $tag ] ) && '' !== trim( $atts[ $tag ] ) ) {

			if ( $tag == 'h2' ) {
				$inline_css .= 'class="call-title"';
			}

			if ( !empty($atts[ 'color' ]) ) {
				$styling .= 'style="' . vc_get_css_color( 'color', $atts['color'] ) . '"';
			}

			return '<' . $tag . ' ' . $styling . ' ' . $inline_css . ' ' . $styling . '>' . $atts[$tag] . '</' . $tag . '>';
		}

		return '';
	}

	public function getForm( $atts ) {

		$form = $data = $css_animation = '';

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

	public function getOneButton( $atts ) {
		$output = '';
		$output .= $this->getButton($atts);
		return $output;
	}

	public function getButton( $atts ) {
		$link = $atts['link'];

		if ( empty($link) ) return '';

		$url = vc_build_link( $link );
		$buttonClasses = 'btn btn-big ' . $atts['button_style'];

		if ( strlen( $link ) > 0 && strlen( $url['url'] ) > 0 ) {
			return '<a class="' . esc_attr($buttonClasses) .'"
			href="' . esc_attr( $url['url'] ) . '"
			target="' . ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) . '">' . esc_html( $url['title'] ) . '</a>';
		}

		return '';
	}

	public function getTemplateVariable( $string ) {
		if ( is_array( $this->template_vars ) && isset( $this->template_vars[ $string ] ) ) {
			return $this->template_vars[ $string ];
		}
		return '';
	}

}