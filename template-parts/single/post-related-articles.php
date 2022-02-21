<?php
$this_id = get_the_ID();
$tag_ids = array();
$tags = wp_get_post_terms( $this_id, 'post_tag' );

if ( !empty($tags) && is_array($tags) ) {

	$query = array(
		'post_type' => 'post',
		'numberposts' => 3,
		'ignore_sticky_posts'=> 1,
		'post__not_in' => array($this_id)
	);

	foreach ($tags as $tag) {
		$tag_ids[] = (int) $tag->term_id;
	}

	if ( !empty($tag_ids) ) {

		$query['tag__in'] = $tag_ids;
		$entries = get_posts( $query ); ?>

		<?php if ( !empty($entries) ): ?>

			<h3 class="title"><?php esc_html_e('Related Posts', 'cryptox'); ?></h3>

			<div class="related-articles">

				<?php foreach( $entries as $post ): setup_postdata($post); ?>

					<div class="entry entry-small <?php if ( has_post_thumbnail( $post ) ): ?>has-post-thumbnail<?php endif; ?>">

						<div class="post-item">

							<div class="thumbnail-attachment">
								<?php if ( '' !== get_the_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'cryptex-660x415-center-center' ); ?>
									</a>
								<?php endif; ?>

								<?php
								$categories = get_the_category_list( " ", '', $post->ID );
								if ( $categories ) {
									echo '<div class="entry-cats">' . $categories . '</div>';
								}
								?>
							</div>

							<div class="entry-body">

								<h5 class="entry-title"><a href="<?php echo esc_url(get_the_permalink()) ?>"><?php echo get_the_title() ?></a></h5>

								<?php echo cryptex_blog_post_meta(); ?>

							</div>

						</div><!--/ .post-item-->

					</div><!--/ .entry-->

				<?php endforeach; ?>

			</div><!--/ .related-articles-->

		<?php endif; wp_reset_postdata(); ?>

		<?php
	}
}