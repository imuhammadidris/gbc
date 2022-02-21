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

		<?php if ( !is_single() ): ?>

			<div class="thumbnail-attachment">
				<?php echo cryptex_link_post_filter( get_the_ID() ); ?>
			</div>

		<?php endif; ?>

		<!-- - - - - - - - - - - - - - Entry body - - - - - - - - - - - - - - - - -->

		<div class="entry-body">

			<?php if ( !is_single() ) : ?>

				<h3 class="entry-title">
					<?php if ( is_sticky() ): ?>
						<span class="sticky-label"><?php esc_html_e('Featured', 'cryptox') ?></span>
					<?php endif; ?>

					<a href="<?php echo esc_url( get_the_permalink() ) ?>"><?php echo get_the_title() ?></a>
				</h3>

				<?php echo cryptex_blog_post_meta(); ?>

			<?php endif; ?>

			<?php
			if ( is_single() ) {
				the_content();
			}
			?>

			<div class="entry-footer">

				<?php
				wp_link_pages( array(
					'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'cryptox' ),
					'after'       => '</div>',
					'link_before' => '<span class="page-number">',
					'link_after'  => '</span>',
				) );
				?>

				<?php if ( !is_single() ) : ?>
					<?php if ( in_array('tags', $cryptex_settings['post-metas']) ): ?>

						<?php
						$tag_list = get_the_tag_list( '', ' ' );
						if ( $tag_list ) {
							echo '<div class="entry-tags">' . $tag_list . '</div>';
						}
						?>

					<?php endif; ?>
				<?php endif; ?>

				<?php if ( !is_single() ): ?>

					<a href="<?php echo esc_url( get_the_permalink() ) ?>" class="btn btn-small btn-style-2"><?php esc_html_e( 'Read More', 'cryptox' ) ?></a>

					<?php if ( function_exists('cryptex_social_share_popup') ): ?>
						<a href="javascript:void(0)" data-post-id="<?php echo absint(get_the_ID()) ?>" class="social-post-btn btn btn-small icon-btn"><i class="licon-share2"></i></a>
					<?php endif; ?>

				<?php endif; ?>

			</div>

		</div><!--/ .entry-body-->

	</div>

</div><!--/ .entry-->
