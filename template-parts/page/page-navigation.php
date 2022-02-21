
<?php
$next_post = get_next_post();
$prev_post = get_previous_post();
$next_post_url = $prev_post_url = "";
$next_post_title = $prev_post_title = "";

if ( is_object($next_post) ) {
	$next_post_url = get_permalink($next_post->ID);
	$next_post_title = $next_post->post_title;
}
if ( is_object($prev_post) ) {
	$prev_post_url = get_permalink($prev_post->ID);
	$prev_post_title = $prev_post->post_title;
}
?>


<?php if ( !empty($prev_post_url) || !empty($next_post_url) ): ?>

	<div class="page-nav">

		<ul class="flex-row flex-justify">

			<?php if ( !empty($prev_post_url) ): ?>

				<li><i class="licon-chevron-left-circle"></i><a href="<?php echo esc_url($prev_post_url) ?>" class="custom-link"><?php echo esc_html($prev_post_title); ?></a></li>

			<?php endif; ?>

			<?php if ( !empty($next_post_url) ): ?>

				<li><a href="<?php echo esc_url($next_post_url) ?>" class="custom-link"><?php echo esc_html($next_post_title); ?></a><i class="licon-chevron-right-circle"></i></li>

			<?php endif; ?>

		</ul>

	</div>

<?php endif; ?>