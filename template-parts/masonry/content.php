<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 */

global $cryptex_settings;
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>

	<div class="post-item">

		<!-- - - - - - - - - - - - - - Entry attachment - - - - - - - - - - - - - - - - -->

		<div class="thumbnail-attachment">
			<?php if ( '' !== get_the_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'cryptex-950x620-center-center' ); ?>
				</a>
			<?php endif; ?>

			<?php
			if ( in_array('cats', $cryptex_settings['post-metas']) ) {
				$categories = get_the_category_list(' ', '', $id);
				if ( $categories ) {
					echo '<div class="entry-cats">' . $categories . '</div>';
				}
			}
			?>
		</div>

		<!-- - - - - - - - - - - - - - Entry body - - - - - - - - - - - - - - - - -->

		<div class="entry-body">

			<h3 class="entry-title">
				<?php if ( is_sticky() ): ?>
					<span class="sticky-label"><?php esc_html_e('Featured', 'cryptox') ?></span>
				<?php endif; ?>

				<a href="<?php echo esc_url( get_the_permalink() ) ?>"><?php echo get_the_title() ?></a>
			</h3>

			<?php echo cryptex_blog_post_meta(); ?>

			<?php if ( has_excerpt() ): ?>
				<div class="entry-masonry-excerpt">
					<?php echo cryptex_get_excerpt( get_the_excerpt(), 140 ); ?>
				</div>
			<?php endif; ?>

			<div class="entry-footer">

				<?php if ( in_array('tags', $cryptex_settings['post-metas']) ): ?>

					<?php
					$tag_list = get_the_tag_list( '', ' ' );
					if ( $tag_list ) {
						echo '<div class="entry-tags">' . $tag_list . '</div>';
					}
					?>

				<?php endif; ?>

				<?php
				wp_link_pages( array(
					'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'cryptox' ),
					'after'       => '</div>',
					'link_before' => '<span class="page-number">',
					'link_after'  => '</span>',
				) );
				?>

				<?php if ( !is_single() ): ?>
					<a href="<?php echo esc_url( get_the_permalink() ) ?>" class="btn btn-small btn-style-2"><?php esc_html_e( 'Read More', 'cryptox' ) ?></a>
				<?php endif; ?>

				<?php if ( function_exists('cryptex_social_share_popup') ): ?>
					<a href="javascript:void(0)" data-post-id="<?php echo absint(get_the_ID()) ?>" class="social-post-btn btn btn-small icon-btn"><i class="licon-share2"></i></a>
				<?php endif; ?>

			</div>

		</div><!--/ .entry-body-->

	</div><!--/ .post-item-->

</div><!--/ .entry-->
