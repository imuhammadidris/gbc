<?php
$this_id = get_the_ID();
$tag_ids = array();
$tags = wp_get_post_terms( $this_id, 'post_tag' );

if ( !empty($tags) && is_array($tags) ) {

	$query = array(
		'post_type' => 'portfolio',
		'numberposts' => 3,
		'ignore_sticky_posts'=> 1,
		'post__not_in' => array( $this_id )
	);

	foreach ( $tags as $tag ) {
		$tag_ids[] = (int) $tag->term_id;
	}

	if ( !empty($tag_ids) ) {

		$query['tag__in'] = $tag_ids;
		$entries = get_posts( $query ); ?>

		<?php if ( !empty($entries) ): ?>

			<h3 class="title"><?php esc_html_e('Related Posts', 'cryptox') ?></h3>

			<div class="portfolio-related portfolio-holder grid-standard cols-3">

				<?php foreach( $entries as $post ): setup_postdata($post); ?>

					<div class="item">

						<div class="project">

							<?php if ( has_post_thumbnail() ): ?>

								<div class="project-image">

									<?php echo get_the_post_thumbnail( get_the_ID(), 'cryptex-660x415-center-center' ); ?>
									<a href="<?php echo wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), '' ) ?>" class="project-link" data-fancybox="group"></a>

								</div><!--/ .project-image-->

							<?php endif; ?>

							<div class="project-description">

								<?php echo get_the_term_list( get_the_ID(), 'portfolio_categories', '<div class="project-cats">', '','</div>' ); ?>

								<h5 class="project-title">
									<a href="<?php echo esc_url( get_the_permalink() ) ?>">
										<?php echo esc_html( get_the_title() ) ?>
									</a>
								</h5>

							</div><!--/ .project-description-->

						</div><!--/ .project-->

					</div><!--/ .item-->

				<?php endforeach; wp_reset_postdata(); ?>

			</div><!--/ .portfolio-holder-->

		<?php endif; ?>

		<?php
	}
}