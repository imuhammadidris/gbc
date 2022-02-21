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

<div class="page-nav">

	<div class="align-left">
		<?php if ( !empty($prev_post_url) ): ?>
			<a href="<?php echo esc_url($prev_post_url) ?>" class="info-btn prev-btn"><?php echo esc_html__('Previous Post', 'cryptox') ?></a>
			<h6><?php echo esc_html($prev_post_title); ?></h6>
		<?php endif; ?>
	</div>

	<div class="align-right">
		<?php if ( !empty($next_post_url) ): ?>
			<a href="<?php echo esc_url($next_post_url) ?>" class="info-btn next-btn"><?php echo esc_html__('Next Post', 'cryptox') ?></a>
			<h6><?php echo esc_html($next_post_title); ?></h6>
		<?php endif; ?>
	</div>

</div><!--/ .page-nav-->