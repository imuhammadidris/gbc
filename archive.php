<?php
/**
 * The template for displaying Archive pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Cryptex
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>

	<div class="entry-box entry-small">

		<?php while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/post/content', get_post_format() );

		endwhile;

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