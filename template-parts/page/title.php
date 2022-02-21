
<?php
global $cryptex_settings, $cryptex_config;
$mode = cryptex_page_title_get_value('mode');

if (
	is_404() ||
	is_search() ||
	is_front_page() ||
	$mode == 'none'
) return;

$wrapper_attributes = $wrap_attributes = array();
$css_classes = array( 'breadcrumbs-wrap' );
$result = '';

if ( cryptex_is_realy_woocommerce_page(false) || cryptex_is_shop_archive()  ) {

	if ( !$cryptex_settings['product-pagetitle'] ) {
		$css_classes[] = 'no-title';
	}

} elseif ( is_singular('tribe_events') ) {

	if ( !$cryptex_settings['events-singular-pagetitle'] ) {
		$css_classes[] = 'no-title';
	}

} elseif ( cryptex_is_events() ) {

	if ( !$cryptex_settings['events-pagetitle'] ) {
		$css_classes[] = 'no-title';
	}

} elseif ( is_singular('team-members') ) {

	if ( !$cryptex_settings['team-members-pagetitle'] ) {
		$css_classes[] = 'no-title';
	}

} elseif ( is_singular('services') ) {

	if ( !$cryptex_settings['services-pagetitle'] ) {
		$css_classes[] = 'no-title';
	}

} elseif ( is_singular('ico') ) {

	if ( !$cryptex_settings['ico-pagetitle'] ) {
		$css_classes[] = 'no-title';
	}

} elseif ( is_singular('portfolio') ) {

	if ( !$cryptex_settings['portfolio-pagetitle'] ) {
		$css_classes[] = 'no-title';
	}

} elseif ( is_single() ) {
	$css_classes[] = 'no-title';
}

$wrapper_attributes[] = 'class="' . esc_attr( trim( implode( ' ', array_unique(array_filter( $css_classes )) )  ) ) . '"';

if ( is_page() ) {

	if ( cryptex_is_shop_installed() && cryptex_is_realy_woocommerce_page(false) ) {

		if ( $cryptex_settings['product-pagetitle'] ) {
			$result .= cryptex_page_title();
		}

		if ( $cryptex_settings['product-breadcrumbs'] ) {
			$result .= cryptex_breadcrumbs();
		}

	} else {

		if ( $cryptex_settings['show-pagetitle'] ) {
			$result .= cryptex_page_title();
		}

		if ( $cryptex_settings['show-breadcrumbs'] ) {
			$result .= cryptex_breadcrumbs();
		}

	}

} elseif ( is_singular('portfolio') ) {

	if ( $cryptex_settings['portfolio-pagetitle'] ) {
		$result .= cryptex_page_title();
	}

	if ( $cryptex_settings['portfolio-breadcrumbs'] ) {
		$result .= cryptex_breadcrumbs();
	}

} elseif ( cryptex_is_product() ) {

	if ( $cryptex_settings['product-pagetitle'] ) {
		$result .= cryptex_page_title();
	}

	if ( $cryptex_settings['product-breadcrumbs'] ) {
		$result .= cryptex_breadcrumbs();
	}

} elseif ( is_singular('tribe_events') ) {

	if ($cryptex_settings['events-singular-pagetitle']) {
		$result .= cryptex_page_title();
	}

	if ($cryptex_settings['events-singular-breadcrumbs']) {
		$result .= cryptex_breadcrumbs();
	}

} elseif ( is_singular('team-members') ) {

	if ( $cryptex_settings['team-members-singular-pagetitle'] ) {
		$result .= cryptex_page_title();
	}

	if ( $cryptex_settings['team-members-singular-breadcrumbs'] ) {
		$result .= cryptex_breadcrumbs();
	}

} elseif ( is_singular('services') ) {

	if ( $cryptex_settings['services-singular-pagetitle'] ) {
		$result .= cryptex_page_title();
	}

	if ( $cryptex_settings['services-singular-breadcrumbs'] ) {
		$result .= cryptex_breadcrumbs();
	}

} elseif ( is_singular('ico') ) {

	if ( $cryptex_settings['ico-singular-pagetitle'] ) {
		$result .= cryptex_page_title();
	}

	if ( $cryptex_settings['ico-singular-breadcrumbs'] ) {
		$result .= cryptex_breadcrumbs();
	}

} elseif ( is_single() ) {

	if ( $cryptex_settings['post-breadcrumbs'] ) {
		$result .= cryptex_breadcrumbs();
	}

} elseif ( is_search() ) {

	global $wp_query;

	if ( !empty($wp_query->found_posts) ) {

		if ( $wp_query->found_posts > 1 ) {

			$result .= cryptex_page_title(
				array(
					'title' => esc_attr__('Search results for:', 'cryptox')." " . esc_attr(get_search_query()) . " (". $wp_query->found_posts .")"
				)
			);

		} else {

			$result .= cryptex_page_title(
				array(
					'title' => esc_attr__('Search result for:', 'cryptox')." " . get_search_query() . " (". $wp_query->found_posts .")"
				)
			);

		}

	} else {

		if ( !empty($_GET['s']) ) {

			$result .= cryptex_page_title(
				array(
					'title' => esc_attr__('Search results for:', 'cryptox') . " " . get_search_query()
				)
			);

		} else {

			$result .= cryptex_page_title(
				array(
					'title' => esc_attr__('To search the site please enter a valid term', 'cryptox')
				)
			);

		}

	}

} else {

	if ( cryptex_is_shop_archive() ) {

		if ($cryptex_settings['product-pagetitle']) {
			$result .= cryptex_page_title();
		}

		if ($cryptex_settings['product-breadcrumbs']) {
			$result .= cryptex_breadcrumbs();
		}

	} elseif ( cryptex_is_events() ) {

		if ( $cryptex_settings['events-pagetitle'] ) {
			$result .= cryptex_page_title(
				array(
					'title' => esc_attr__('Events List', 'cryptox')
				)
			);
		}

		if ( $cryptex_settings['events-breadcrumbs'] ) {
			$result .= cryptex_breadcrumbs();
		}

	} else {

		$result .= cryptex_page_title(
			array(
				'title' => get_the_archive_title(),
				'subtitle' => get_the_archive_description()
			)
		);

		$result .= cryptex_breadcrumbs();

	}


}

?>

<?php if ( !empty($result) ): ?>

	<div <?php echo implode( ' ', $wrapper_attributes ) ?>>

		<div class="container">
			<?php echo sprintf( '%s', $result ); ?>
		</div>

	</div>

<?php endif; ?>
