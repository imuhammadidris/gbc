<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$title = $tag_title = $description = $title_color = $description_color = '';

extract( shortcode_atts( array(
	'title' => '',
	'style' => 'style-1'
), $atts ) );

global $tabarr;
$tabarr = array();

do_shortcode( $content );

ob_start(); ?>

<?php if ( $title ):  ?>
	<h3 class="title"><?php echo esc_html($title) ?></h3>
<?php endif; ?>

<div class="tabs tabs-section vertical <?php echo sanitize_html_class($style) ?> clearfix">

	<ul class="tabs-nav clearfix">

		<?php if ( isset($tabarr) && !empty($tabarr) ): ?>

			<?php foreach( $tabarr as $key => $value ): ?>
				<li>
					<a href="#tour-<?php echo esc_attr($value['tab_id']) ?>">
					<?php echo esc_html($value['title']) ?></a>
				</li>
			<?php endforeach; ?>

		<?php endif; ?>

	</ul>

	<div class="tabs-content">
		<?php echo wpb_js_remove_wpautop( $content ) ?>
	</div>

</div><!--/ .tabs-->

<?php echo ob_get_clean();
