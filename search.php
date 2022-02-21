<?php
	/**
	 * The template for displaying Search Results pages.
	 */
	get_header();
?>

<?php if ( have_posts() ) : ?>

	<?php
	global $cryptex_settings;
	$loop_count = 1;
	$page = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	if ( $page > 1 ) {
		$loop_count = ((int) ($page - 1) * (int) get_query_var('posts_per_page')) + 1;
	}
	?>

	<div class="entry-box entry-small">

		<?php while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>

				<div class="post-item">

					<!-- - - - - - - - - - - - - - Entry attachment - - - - - - - - - - - - - - - - -->

					<div class="thumbnail-attachment">
						<?php if ('' !== get_the_post_thumbnail()) : ?>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail('cryptex-950x620-center-center'); ?>
							</a>
						<?php endif; ?>

						<?php
						if (in_array('cats', $cryptex_settings['post-metas'])) {
							$categories = get_the_category_list(' ', '', $id);
							if ($categories) {
								echo '<div class="entry-cats">' . $categories . '</div>';
							}
						}
						?>
					</div>

					<!-- - - - - - - - - - - - - - Entry body - - - - - - - - - - - - - - - - -->

					<div class="entry-body">

						<h3 class="entry-title">
							<?php if (is_sticky()): ?>
								<span class="sticky-label"><?php esc_html_e('Featured', 'cryptox') ?></span>
							<?php endif; ?>

							<a href="<?php echo esc_url(get_the_permalink()) ?>"><?php echo get_the_title() ?></a>
						</h3>

						<?php echo cryptex_blog_post_meta(); ?>

						<?php
						if ( has_excerpt() ) {
							the_excerpt();
						}
						?>

						<div class="entry-footer">

							<?php if (in_array('tags', $cryptex_settings['post-metas'])): ?>

								<?php
								$tag_list = get_the_tag_list('', ' ');
								if ($tag_list) {
									echo '<div class="entry-tags">' . $tag_list . '</div>';
								}
								?>

							<?php endif; ?>

							<?php
							wp_link_pages(array(
								'before' => '<div class="page-links">' . esc_html__('Pages:', 'cryptox'),
								'after' => '</div>',
								'link_before' => '<span class="page-number">',
								'link_after' => '</span>',
							));
							?>

							<?php if ( !is_single() ): ?>
								<a href="<?php echo esc_url(get_the_permalink()) ?>"
								   class="btn btn-small"><?php esc_html_e('Read More', 'cryptox') ?></a>
							<?php endif; ?>

							<?php if ( function_exists('cryptex_social_share_popup') ): ?>
								<a href="javascript:void(0)" data-post-id="<?php echo absint(get_the_ID()) ?>"
								   class="social-post-btn btn btn-small icon-btn"><i class="licon-share2"></i></a>
							<?php endif; ?>

						</div>

					</div><!--/ .entry-body-->

				</div><!--/ .post-item-->

			</div><!--/ .entry-->

		<?php endwhile;

		?>

	</div><!--/ .entry-box-->

	<?php
	the_posts_pagination( array(
		'prev_text' => '<span class="screen-reader-text">' . esc_html__( 'Previous page', 'cryptox' ) . '</span>',
		'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next page', 'cryptox' ) . '</span>',
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'cryptox' ) . ' </span>'
	) );
	?>

<?php else : ?>

	<?php get_template_part( 'template-parts/post/content', 'none' ); ?>

<?php endif; ?>

<?php get_footer(); ?>
