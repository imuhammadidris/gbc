<?php
/**
 * Custom Cryptex template tags
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordPress
 * @since Cryptex 1.0
 */

if ( !function_exists('cryptex_logo') ) {

	function cryptex_logo() {
		global $cryptex_settings, $cryptex_config;

		switch ( $cryptex_config['header_style'] ) {
			case 'style-1':
				$logo = $cryptex_settings['logo']['url'];
				$logo_hidpi = $cryptex_settings['logo_hidpi']['url'];
				break;
			case 'style-2':
				$logo = $cryptex_settings['logo_header_2']['url'];
				$logo_hidpi = $cryptex_settings['logo_header_2_hidpi']['url'];
				break;
			case 'style-3':
				$logo = $cryptex_settings['logo_header_3']['url'];
				$logo_hidpi = $cryptex_settings['logo_header_3_hidpi']['url'];
				break;
			default:
				$logo = $cryptex_settings['logo']['url'];
				$logo_hidpi = $cryptex_settings['logo_hidpi']['url'];
				break;
		}

		ob_start();

		if ( !$logo ): ?>

			<h1 class="logo"><?php else : ?><?php endif; ?>

			<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" rel="home">
				<?php if ( $logo ) {
					echo '<img class="standard-logo" src="' . esc_url(str_replace( array( 'http:', 'https:' ), '', $logo)) . '" srcset="'. esc_url( str_replace( array( 'http:', 'https:' ), '', $logo_hidpi ) ) .' 2x" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" />';
				} else {
					bloginfo( 'name' );
				} ?>
			</a>

		<?php if ( !$logo ) : ?></h1><?php else : ?><?php endif;

		return apply_filters( 'cryptex_logo', ob_get_clean() );
	}

}

if ( !function_exists('cryptex_main_navigation') ) {
	function cryptex_main_navigation($theme_location = 'primary', $menu_class = 'clearfix' ) {

		if ( is_array($menu_class) ) {
			$menu_class = implode(" ", $menu_class);
		}

		$defaults = array(
			'container' => 'ul',
			'menu_class' => $menu_class,
			'theme_location' => $theme_location,
			'fallback_cb' => false,
			'walker' => new cryptex_primary_navwalker
		);

		if ( $theme_location == 'primary' ) {

			if ( has_nav_menu($theme_location) ) {
				wp_nav_menu( $defaults );
			} else {
				echo '<ul>';
				wp_list_pages('title_li=');
				echo '</ul>';
			}

		} elseif ( $theme_location == 'secondary' ) {
			if ( has_nav_menu($theme_location) ) {
				wp_nav_menu( $defaults );
			}
		}

	}

}

if ( !function_exists('cryptex_mobile_menu') ) {

	function cryptex_mobile_menu() {
		ob_start();

		$defaults = array(
			'container' => 'ul',
			'menu_class' => 'mobile-advanced',
			'theme_location' => 'primary',
			'fallback_cb' => false,
			'before' => '',
			'after' => '',
			'link_before' => '',
			'link_after' => '',
			'walker' => new cryptex_mobile_navwalker
		);

		if ( has_nav_menu('primary') ) {
			wp_nav_menu( $defaults );
		} else {
			echo '<ul class="mobile-advanced">';
			wp_list_pages('title_li=');
			echo '</ul>';
		}

		$output = str_replace( '&nbsp;', '', ob_get_clean() );
		return apply_filters( 'cryptex_mobile_menu', $output );
	}
}


if ( ! function_exists('cryptex_excerpt') ) :
	/**
	 * Displays the optional excerpt.
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * Create your own twentysixteen_excerpt() function to override in a child theme.
	 *
	 * @subpackage Cryptex
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function cryptex_excerpt($class = 'entry-summary' ) {
		$class = esc_attr( $class );

		if ( has_excerpt() || is_search() ) : ?>
			<div class="<?php echo sanitize_html_class($class); ?>">
				<?php the_excerpt(); ?>
			</div><!-- .<?php echo sanitize_html_class($class); ?> -->
		<?php endif;
	}
endif;

if ( ! function_exists('cryptex_post_thumbnail') ) :
	function cryptex_post_thumbnail($size = 'post-thumbnail' ) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="kw-entry-thumb">
				<?php the_post_thumbnail($size); ?>
			</div>

		<?php else : ?>

			<a class="kw-entry-thumb" href="<?php the_permalink(); ?>" aria-hidden="true">
				<?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
			</a>

		<?php endif; // End is_singular()
	}
endif;

if ( ! function_exists('cryptex_prev_next_page_links') ) :

	function cryptex_prev_next_page_links() {

		global $cryptex_settings;

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

		if ( !empty($prev_post_url) || !empty($next_post_url) ): ?>

			<?php if ( $cryptex_settings['job-type-fields'] == 'property' ): ?>

				<?php if ( !empty($prev_post_url) ): ?>
					<a class="kw-nav-prev" href="<?php echo esc_url($prev_post_url) ?>" title="<?php echo esc_attr($prev_post_title) ?>"><?php esc_html_e('Prev Property', 'cryptox') ?></a>
				<?php endif; ?>

				<?php if ( !empty($next_post_url) ): ?>
					<a class="kw-nav-next" href="<?php echo esc_url($next_post_url) ?>" title="<?php echo esc_attr($next_post_title) ?>"><?php esc_html_e('Next Property', 'cryptox') ?></a>
				<?php endif; ?>

			<?php else: ?>

				<?php if ( !empty($prev_post_url) ): ?>
					<div class="kw-page-nav-item">
						<span class="lnr icon-chevron-left-circle"></span><a title="<?php echo esc_attr($prev_post_title) ?>" href="<?php echo esc_url($prev_post_url) ?>"><?php esc_html_e('Previous Ad', 'cryptox') ?></a>
					</div>
				<?php endif; ?>

				<?php if ( !empty($next_post_url) ): ?>
					<div class="kw-page-nav-item kw-right-icon">
						<span class="lnr icon-chevron-right-circle"></span><a title="<?php echo esc_attr($next_post_title) ?>" href="<?php echo esc_url($next_post_url) ?>"><?php esc_html_e('Next Ad', 'cryptox') ?></a>
					</div>
				<?php endif; ?>

			<?php endif; ?>

		<?php endif;

	}
endif;

if ( ! function_exists('cryptex_entry_date') ) :
	/**
	 * Prints HTML with date information for current post.
	 *
	 */
	function cryptex_entry_date($atts = array() ) {

		global $cryptex_settings;

		$defaults = array();
		$atts = wp_parse_args( $atts, $defaults );

		if ( in_array('date', $cryptex_settings['post-metas']) ) {

			echo sprintf( '<div class="date"><h6 class="month">%1$s</h6><h4 class="day">%2$s</h4></div>',
				esc_attr( get_the_date( 'M' ) ),
				esc_attr( get_the_date( 'd' ) )
			);

		}

	}
endif;



/*	Blog Post Meta
/* ---------------------------------------------------------------------- */

if ( ! function_exists('cryptex_blog_post_meta') ) :

	function cryptex_blog_post_meta( $id = 0, $args = array() ) {

		global $cryptex_settings;
		$defaults = array(
			'date' => true,
			'container' => true,
			'author' => true,
			'cats' => false,
			'tags' => false,
			'type' => 'small'
		);
		$args = wp_parse_args( $args, $defaults );
		$args = (object) $args;

		ob_start(); ?>

		<?php if ( is_single() ): ?>

			<?php if ( $args->container ): ?><div class="entry-meta"><?php endif; ?>

				<?php if ( $args->date ): ?>

					<?php if ( in_array('date', $cryptex_settings['single-post-metas']) ): ?>

						<?php
						$time_string = sprintf( '<time class="entry-date" datetime="%1$s">%2$s</time>',
							get_the_date( DATE_W3C ), get_the_date()
						);
						printf( '%1$s', $time_string );
						?>

					<?php endif; ?>

				<?php endif; ?>

				<?php if ( $args->author ): ?>

					<?php if ( in_array('author', $cryptex_settings['single-post-metas']) ): ?>

						<?php
						echo sprintf( '<span class="entry-author">%1$s <a href="%2$s">%3$s</a></span>',
							esc_html__('by', 'cryptox'),
							esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
							get_the_author_meta( 'display_name' )
						);
						?>

					<?php endif; ?>

				<?php endif; ?>

			<?php if ( $args->container ): ?></div><?php endif; ?>

		<?php else: ?>

			<?php if ( $args->container ): ?><div class="entry-meta"><?php endif; ?>

				<?php if ( $args->type == 'default' ): ?>

					<?php if ( $args->cats ): ?>

						<?php if ( in_array('cats', $cryptex_settings['post-metas']) ): ?>

							<?php
								$categories = get_the_category_list(' ', '', $id);
								if ( $categories ) {
									echo '<div class="entry-cats">' . $categories . '</div>';
								}
							?>

						<?php endif; ?>

					<?php endif; ?>

					<?php if ( $args->tags ): ?>

						<?php if ( in_array('tags', $cryptex_settings['post-metas']) ): ?>

							<?php
							$tag_list = get_the_tag_list( '', ' ' );
							if ( $tag_list ) {
								echo '<div class="entry-tags">' . $tag_list . '</div>';
							}
							?>

						<?php endif; ?>

					<?php endif; ?>

				<?php elseif ( $args->type == 'carousel' ): ?>

					<?php if ( $args->cats ): ?>

						<?php if ( in_array('cats', $cryptex_settings['post-metas']) ): ?>

							<?php
							$categories = get_the_category_list('', '', $id);
							if ( $categories ) {
								echo '<div class="entry-cats">' . $categories . '</div>';
							}
							?>

						<?php endif; ?>

					<?php endif; ?>

					<?php if ( $args->date ): ?>

						<?php if ( in_array('date', $cryptex_settings['post-metas']) ): ?>

							<?php
							$time_string = sprintf( '<time class="entry-date" datetime="%1$s">%2$s</time>',
								get_the_date( DATE_W3C ), get_the_date()
							);
							printf( '%1$s', $time_string );
							?>

						<?php endif; ?>

					<?php endif; ?>

				<?php elseif ( $args->type == 'small' ): ?>

					<?php if ( $args->date ): ?>

						<?php if ( in_array('date', $cryptex_settings['post-metas']) ): ?>

							<?php
							$time_string = sprintf( '<time class="entry-date" datetime="%1$s">%2$s</time>',
								get_the_date( DATE_W3C ), get_the_date()
							);
							printf( '%1$s', $time_string );
							?>

						<?php endif; ?>

					<?php endif; ?>

					<?php if ( $args->author ): ?>

						<?php
							echo sprintf( '<span>%1$s <a href="%2$s">%3$s</a></span>',
								esc_html__('by', 'cryptox'),
								esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
								get_the_author()
							);
						?>

					<?php endif; ?>

				<?php endif; ?>

			<?php if ( $args->container ): ?></div><?php endif; ?>

		<?php endif; ?>

		<?php return ob_get_clean();
	}
endif;

if ( ! function_exists('cryptex_comments_popup_link') ) :

	function cryptex_comments_popup_link($id = false, $echo = false, $comments_without_text = false, $zero = false, $one = false, $more = false, $css_class = 'kw-entry-comments-link' ) {
		$number = get_comments_number( $id );

		if ( post_password_required() ) {
			esc_html_e( 'Enter your password to view comments.', 'cryptox' );
			return;
		}

		$output = '<a href="';
		$output .= apply_filters( 'cryptex_respond_link', get_permalink($id) . '#respond', $id );
		$output .= '"';

		if ( !empty( $css_class ) ) {
			$output .= ' class="'. $css_class .'" ';
		}

		$output .= '>';

		if ( false === $more ) {

			if ( $comments_without_text ) {
				$output .= sprintf( '%s', number_format_i18n( $number ) );
			} else {
				$output .= sprintf( _n( '%s Comment', '%s Comments', $number, 'cryptox' ), number_format_i18n( $number ) );
			}

		} else {
			// % Comments
			/* translators: If comment number in your language requires declension,
			 * translate this to 'on'. Do not translate into your own language.
			 */
			if ( 'on' === _x( 'off', 'Comment number declension: on or off', 'cryptox' ) ) {
				$text = preg_replace( '#<span class="screen-reader-text">.+?</span>#', '', $more );
				$text = preg_replace( '/&.+?;/', '', $text ); // Kill entities
				$text = trim( strip_tags( $text ), '% ' );

				// Replace '% Comments' with a proper plural form
				if ( $text && ! preg_match( '/[0-9]+/', $text ) && false !== strpos( $more, '%' ) ) {
					/* translators: %s: number of comments */
					$new_text = _n( '%s Comment', '%s Comments', $number, 'cryptox' );
					$new_text = trim( sprintf( $new_text, '' ) );

					$more = str_replace( $text, $new_text, $more );
					if ( false === strpos( $more, '%' ) ) {
						$more = '% ' . $more;
					}
				}
			}

			$output .= str_replace( '%', number_format_i18n( $number ), $more );
		}

		$output .= '</a>';

		if ( $echo ) {
			echo sprintf('%s', $output);
		} else {
			return $output;
		}

	}
endif;

if ( ! function_exists('cryptex_get_excerpt') ) :
	/**
	 * Displays the get excerpt.
	 *
	 */
	function cryptex_get_excerpt($post_content, $limit = 120 ) {
		if ( empty($post_content) ) return '';
		$content = cryptex_string_truncate( $post_content, $limit, ' ', "...", true, '' );
		$content = apply_filters( 'the_excerpt', $content );
		$content = do_shortcode($content);
		return $content;
	}
endif;


if ( ! function_exists('cryptex_get_search_excerpt') ) :
	/**
	 * Displays the get excerpt for search.
	 *
	 */
	function cryptex_get_search_excerpt($limit = 150, $more_link = true ) {

		if ( !$limit ) { $limit = 45; }

		if ( has_excerpt() ) {
			$content = strip_tags( strip_shortcodes(get_the_excerpt()) );
		} else {
			$content = strip_tags( strip_shortcodes(get_the_content()) );
		}

		$content = explode(' ', $content, $limit);

		if ( count($content) >= $limit ) {
			array_pop($content);
			if ($more_link)
				$content = implode(" ",$content).'... ';
			else
				$content = implode(" ",$content).' [...]';
		} else {
			$content = implode(" ",$content);
		}

		$content = apply_filters('the_content', $content);
		$content = do_shortcode($content);
		return $content;
	}
endif;

if ( ! function_exists( 'cryptex_format_date' ) ) {
	/**
	 * Formatted Date
	 *
	 * Returns formatted date
	 *
	 * @return string
	 */
	function cryptex_format_date( $date, $display_time = false, $date_format = '' ) {

		$date = strtotime( $date );

		if ( $date_format ) {
			$format = $date_format;
		} else {
			$format = get_option( 'date_format' );
		}

		$date = date_i18n( $format, $date );

		return apply_filters( 'cryptex_formatted_date', $date, $display_time, $date_format );

	};
}

if ( !function_exists('cryptex_get_term_meta') ) {
	function cryptex_get_term_meta($term, $term_id = null, $is_tax = true ) {

		if ( function_exists('get_term_meta') ) {
			return get_term_meta( $term_id, $term, true );
		}

		return false;
	}
}