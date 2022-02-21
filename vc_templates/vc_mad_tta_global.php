<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 */
$el_class = $css = $link = $link_output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->resetVariables( $atts, $content );
extract( $atts );

$prepareContent = $this->getTemplateVariable( 'content' );

$link = ( '||' === $atts['link'] ) ? '' : $atts['link'];
$link = vc_build_link( $link );
$use_link = false;
if ( strlen( $link['url'] ) > 0 ) {
	$use_link = true;
	$a_href = $link['url'];
	$a_title = $link['title'];
	$a_target = $link['target'];
}

if ( $use_link ) {
	$link_output .= '<a href="'. esc_url($a_href) .'" target="'. esc_attr($a_target) .'" class="btn">'. esc_html($a_title) .'</a>';
}

$class_to_filter = $this->getTtaGeneralClasses();
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
$css_class = $class_to_filter;

$output = '<div ' . $this->getWrapperAttributes() . '>';
	$output .= $this->getTemplateVariable( 'title' );
	$output .= '<div ' . $this->getElementAttributes()  . ' class="' . esc_attr( $css_class ) . '">';
		$output .= $prepareContent;
	$output .= '</div>';
	$output .= $link_output;
$output .= '</div>';

echo sprintf('%s', $output);
