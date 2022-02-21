<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$title = $tag_title = $description = $title_color = $description_color = '';

extract( shortcode_atts( array(
	'title' => '',
	'heading' => 'h3',
	'align_title' => 'align-left',
	'style' => 'style-1',
	'description' => ''
), $atts ) );

global $tabarr;
$tabarr = array();

do_shortcode( $content );

ob_start(); ?>

<?php
echo Cryptex_Vc_Config::getParamTitle(
	array(
		'title' => $title,
		'heading' => $heading,
		'align_title' => $align_title
	)
);
?>

<div class="tabs tabs-section <?php echo sanitize_html_class($style) ?> clearfix">

	<ul class="tabs-nav clearfix <?php echo sanitize_html_class($align_title) ?>">

		<?php if ( isset($tabarr) && !empty($tabarr) ): ?>

			<?php foreach( $tabarr as $key => $value ): ?>
				<li><a href="#tab-<?php echo esc_attr($value['tab_id']) ?>">
						<?php if (isset($value['icon']) && $value['icon'] != 'none'): ?>
							<span class="<?php echo esc_attr($value['icon']) ?>"></span>
						<?php endif; ?>
					<?php echo esc_html($value['title']) ?></a>
				</li>
			<?php endforeach; ?>

		<?php endif; ?>

	</ul>

	<div class="tabs-content">
		<?php echo wpb_js_remove_wpautop( $content ) ?>
	</div>

</div>

<?php echo ob_get_clean();
