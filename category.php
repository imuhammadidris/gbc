<?php
/**
 * The template for displaying Category pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Cryptex
 */

get_header(); ?>
<?php if ( have_posts() ) : ?>

	<?php
	global $cryptex_settings;
	$wrapper_attributes = array();
	$category = get_queried_object();
	$term_columns = cryptex_get_term_meta( 'pix_term_columns', $category->term_id );
	$term_layout = cryptex_get_term_meta( 'pix_term_layout', $category->term_id );
	$term_with_border = cryptex_get_term_meta( 'pix_term_with_border', $category->term_id );

	$first_big = $cryptex_settings['blog-archive-big-post'];

	if ( !$term_columns ) {
		$term_columns = $cryptex_settings['blog-archive-columns'];
	}

	if ( !$term_layout ) {
		$term_layout = $cryptex_settings['blog-archive-layout'];
	}

	$css_classes = array( 'entry-box', $term_layout );

	if ( !empty($term_columns) ) {
		$css_classes[] = 'cols-' . $term_columns;
	}

	if ( $term_with_border == '0' ) {
		$css_classes[] = 'entry-no-border';
	}

	$css_class = preg_replace( '/\s+/', ' ', implode( ' ', array_filter( $css_classes ) ) );
	$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
	?>

	<?php $row = 1; ?>

	<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

		<?php while ( have_posts() ) : the_post();

			if ( wp_is_mobile() ) {

				get_template_part( 'template-parts/post/content', 'small' );

			} else {

				if ( $row == 1 && $first_big && has_post_thumbnail() ) {
					get_template_part( 'template-parts/post/content', 'big' );
				} else {
					get_template_part( 'template-parts/post/content', 'small' );
				}

			}

			++$row;

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