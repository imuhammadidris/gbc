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
					<?php the_post_thumbnail( 'cryptex-455x300-center-center' ); ?>
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

			<h5 class="entry-title">
				<?php if ( is_sticky() ): ?>
					<span class="sticky-label"><?php esc_html_e('Featured', 'cryptox') ?></span>
				<?php endif; ?>

				<a href="<?php echo esc_url( get_the_permalink() ) ?>"><?php echo get_the_title() ?></a>
			</h5>

			<?php echo cryptex_blog_post_meta(); ?>

		</div><!--/ .entry-body-->

	</div><!--/ .post-item-->

</div><!--/ .entry-->
