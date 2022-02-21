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

<div id="post-<?php the_ID(); ?>" <?php post_class( array( 'entry', 'single-entry' ) ); ?>>

	<div class="post-item">

		<div class="news-holder">

			<?php if ( '' !== get_the_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'cryptex-1120x520-center-center' ); ?>
			<?php endif; ?>

			<div class="entry__overlay">

				<?php echo cryptex_blog_post_meta( get_the_ID(), array(
					'type' => 'carousel',
					'cats' => true
				)) ?>

				<h3 class="entry-title">
					<a href="<?php echo esc_url(get_the_permalink()) ?>"><?php echo esc_html(get_the_title()) ?></a>
				</h3>

			</div><!--/ .entry__overlay-->

		</div>

	</div><!--/ .post-item-->

</div><!--/ .entry-->
