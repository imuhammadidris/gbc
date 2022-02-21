<?php
/**
 * Custom functions of the theme templates.
 *
 * @subpackage Cryptex
 */

if ( !function_exists('cryptex_get_google_maps_api_key') ) {
	function cryptex_get_google_maps_api_key() {

		global $cryptex_settings;
		$google_maps_key = $cryptex_settings['gmap-api'];

		if ( ! empty( $google_maps_key ) ) {
			$google_maps_key = '&key=' . $google_maps_key;
		} else {
			$google_maps_key = '';
		}
		return esc_attr( trim( $google_maps_key ) );
	}
}


if ( !function_exists('cryptex_get_google_maps_api_url') ) {
	function cryptex_get_google_maps_api_url() {
		$base = '//maps.googleapis.com/maps/api/js';

		$args = array(
			'language' => get_locale() ? substr( get_locale(), 0, 2 ) : '',
		);

		$args['libraries'] = 'places';

		// API key.
		$key = cryptex_get_google_maps_api_key();

		if ( '' !== $key ) {
			$args['key'] = $key;
		}

		$url = esc_url_raw( add_query_arg( $args, $base ) );

		return apply_filters( 'cryptex_google_maps_api_url', $url, $args );
	}
}

/*	Post ID
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_post_id') ) {

	function cryptex_post_id() {
		$object_id = get_queried_object_id();

		$post_id = false;

		if ( get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) && is_home() ) {
			$post_id = get_option( 'page_for_posts' );
		} else {
			// Use the $object_id if available.
			if ( isset( $object_id ) ) {
				$post_id = $object_id;
			}
			// If we're not on a singular post, set to false.
			if ( ! is_singular() ) {
				$post_id = false;
			}
			// Front page is the posts page.
			if ( isset( $object_id ) && 'posts' == get_option( 'show_on_front' ) && is_home() ) {
				$post_id = $object_id;
			}
			// The woocommerce shop page.
			if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) ) {
				$post_id = get_option( 'woocommerce_shop_page_id' );
			}
		}

		return $post_id;
	}
}

/*  Is shop installed
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_is_shop_installed') ) {
	function cryptex_is_shop_installed() {
		global $woocommerce;
		if ( isset( $woocommerce ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/*  Is product
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_is_product') ) {
	function cryptex_is_product() {
		return is_singular( array( 'product' ) );
	}
}

/*  Get WC page id
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_wc_get_page_id') ) {
	function cryptex_wc_get_page_id($page ) {

		if ( $page == 'pay' || $page == 'thanks' ) {
			_deprecated_argument( __FUNCTION__, '2.1', 'The "pay" and "thanks" pages are no-longer used - an endpoint is added to the checkout instead. To get a valid link use the WC_Order::get_checkout_payment_url() or WC_Order::get_checkout_order_received_url() methods instead.' );

			$page = 'checkout';
		}
		if ( $page == 'change_password' || $page == 'edit_address' || $page == 'lost_password' ) {
			_deprecated_argument( __FUNCTION__, '2.1', 'The "change_password", "edit_address" and "lost_password" pages are no-longer used - an endpoint is added to the my-account instead. To get a valid link use the wc_customer_edit_account_url() function instead.' );

			$page = 'myaccount';
		}

		$page = apply_filters( 'woocommerce_get_' . $page . '_page_id', get_option('woocommerce_' . $page . '_page_id' ) );

		return $page ? absint( $page ) : -1;
	}
}

if ( !function_exists('cryptex_is_events') ) {
	function cryptex_is_events() {
		return is_post_type_archive( 'tribe_events' );
	}
}


/*  Is shop
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_is_shop_archive') ) {
	function cryptex_is_shop_archive() {
		return is_post_type_archive( 'product' ) || is_page( cryptex_wc_get_page_id( 'shop' ) );
	}
}

/*  Is product tax
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_is_product_tax') ) {
	function cryptex_is_product_tax() {
		return is_tax( get_object_taxonomies( 'product' ) );
	}
}

/*  Is product category
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_is_product_category') ) {
	function cryptex_is_product_category($term = '' ) {
		return is_tax( 'product_cat', $term );
	}
}

/*  Is product tag
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_is_product_tag') ) {
	function cryptex_is_product_tag($term = '' ) {
		return is_tax( 'product_tag', $term );
	}
}

/*  Is really woocommerce pages
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_is_realy_woocommerce_page') ) {
	function cryptex_is_realy_woocommerce_page( $shop_archive = true ) {

		if ( $shop_archive ) {
			if ( cryptex_is_shop_archive() || cryptex_is_product_tax() || cryptex_is_product() ) {
				return true;
			}
		}

		$woocommerce_keys = array("cryptex_woocommerce_shop_page_id",
			"woocommerce_terms_page_id",
			"woocommerce_cart_page_id",
			"woocommerce_checkout_page_id",
			"woocommerce_pay_page_id",
			"woocommerce_thanks_page_id",
			"woocommerce_myaccount_page_id",
			"woocommerce_edit_address_page_id",
			"woocommerce_view_order_page_id",
			"woocommerce_change_password_page_id",
			"woocommerce_logout_page_id",
			"woocommerce_lost_password_page_id"
		);

		foreach ( $woocommerce_keys as $wc_page_id ) {
			if ( get_the_ID() == get_option($wc_page_id, 0 ) ) {
				return true;
			}
		}
		return false;
	}
}

/*	Oembed html filter
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_oembed_html') ) {

	function cryptex_oembed_html($return) {
		return '<div class="responsive-iframe">' . $return . '</div>';
	}
	add_filter('embed_oembed_html', 'cryptex_oembed_html');
}

/* 	Pagination
/* ---------------------------------------------------------------------- */

if( !function_exists('cryptex_pagination') ) {

	function cryptex_pagination($entries = '', $args = array(), $range = 10 ) {

		global $wp_query;

		$paged = (get_query_var('paged')) ? get_query_var('paged') : false;

		if ( $paged === false ) $paged = (get_query_var('page')) ? get_query_var('page') : false;
		if ( $paged === false ) $paged = 1;

		if ($entries == '') {

			if ( isset( $wp_query->max_num_pages ) )
				$pages = $wp_query->max_num_pages;

			if( !$pages )
				$pages = 1;

		} else {
			$pages = $entries->max_num_pages;
		}

		if ( 1 != $pages ) { ob_start(); ?>

			<!-- - - - - - - - - - - - - - Pagination - - - - - - - - - - - - - - - - -->

			<ul class="pagination">

				<?php if( $paged > 1 ):  ?>
					<li><a class='prev-page' href='<?php echo esc_url(get_pagenum_link( $paged - 1 )) ?>'></a></li>
				<?php endif; ?>

				<?php for( $i=1; $i <= $pages; $i++ ): ?>
					<?php if ( 1 != $pages &&( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $range ) ): ?>
						<?php $class = ( $paged == $i ) ? " active" : ''; ?>
						<li class="<?php echo sanitize_html_class($class) ?>"><a class="page-numbers" href='<?php echo esc_url(get_pagenum_link( $i )) ?>'><?php echo esc_html($i) ?></a></li>
					<?php endif; ?>
				<?php endfor; ?>

				<?php if ( $paged < $pages ):  ?>
					<li><a class='next-page' href='<?php echo esc_url(get_pagenum_link( $paged + 1 )) ?>'></a></li>
				<?php endif; ?>

			</ul>

			<!-- - - - - - - - - - - - - - End of Pagination - - - - - - - - - - - - - - - - -->

			<?php return ob_get_clean(); }
	}
}

/*  Get Blog ID
/* ---------------------------------------------------------------------- */

if ( ! function_exists('cryptex_get_blog_id') ) {
	function cryptex_get_blog_id() {
		return apply_filters( 'cryptex_get_blog_id', get_current_blog_id() );
	}
}

if ( ! function_exists('cryptex_get_video') ) {
	function cryptex_get_video($post_id = null ) {

		if ( $post_id === null ) {
			$post_id = get_the_ID();
		}

		if ( !$post_id ) return '';

		$video_background = get_post_meta( $post_id, 'cryptex_page_add_video', true );

		if ( !empty($video_background) ) {
			return $video_background;
		}

		return '';
	}
}


if ( !function_exists('mad_meta') ) {
	function mad_meta() {
		return '';
	}
}

/*	String Truncate
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_string_truncate')) {
	function cryptex_string_truncate($string, $limit, $break=".", $pad="...", $stripClean = false, $excludetags = '<strong><em><span>', $safe_truncate = false) {
		if ( empty($limit) ) return $string;

		if ( $stripClean ) {
			$string = strip_shortcodes(strip_tags($string, $excludetags));
		}

		if ( strlen($string) <= $limit ) return $string;

		if ( false !== ($breakpoint = strpos($string, $break, $limit)) ) {
			if ($breakpoint < strlen($string) - 1) {
				if ($safe_truncate || is_rtl()) {
					$string = mb_strimwidth($string, 0, $breakpoint) . $pad;
				} else {
					$string = substr($string, 0, $breakpoint) . $pad;
				}
			}
		}

		// if there is no breakpoint an no tags we could accidentaly split split inside a word
		if ( !$breakpoint && strlen(strip_tags($string)) == strlen($string) ) {
			if ( $safe_truncate || is_rtl() ) {
				$string = mb_strimwidth($string, 0, $limit) . $pad;
			} else {
				$string = substr($string, 0, $limit) . $pad;
			}
		}

		return $string;
	}
}


/*	Get Site Icon
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_get_site_icon_url') ) {

	function cryptex_get_site_icon_url($size = 512, $url = '' ) {

		global $cryptex_settings;

		$site_icon_id = '';
		$favicon_url = $cryptex_settings['favicon']['url'];
		if ( isset($cryptex_settings['favicon']['id']) ) {
			$site_icon_id = $cryptex_settings['favicon']['id'];
		}

		if ( $site_icon_id ) {
			if ( $size >= 512 ) {
				$size_data = 'full';
			} else {
				$size_data = array( $size, $size );
			}

			$url_data = wp_get_attachment_image_src( $site_icon_id, $size_data );
			if ( $url_data ) {
				$url = $url_data[0];
			}
		} elseif( $favicon_url ) {
			return $favicon_url;
		}

		return $url;
	}
}

/*	Site Icon
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_wp_site_icon') ) {

	function cryptex_wp_site_icon() {

		if ( !has_site_icon() ) {

			global $cryptex_settings;
			$favicon = $cryptex_settings['favicon'];

			if ( ! $favicon ) { return; }

			$meta_tags = array(
				sprintf( '<link rel="icon" href="%s" sizes="32x32" />', esc_url( cryptex_get_site_icon_url( 32 ) ) ),
				sprintf( '<link rel="icon" href="%s" sizes="192x192" />', esc_url( cryptex_get_site_icon_url( 192 ) ) ),
				sprintf( '<link rel="apple-touch-icon-precomposed" href="%s">', esc_url( cryptex_get_site_icon_url( 180 ) ) ),
				sprintf( '<meta name="msapplication-TileImage" content="%s">', esc_url( cryptex_get_site_icon_url( 270 ) ) ),
			);

			$meta_tags = array_filter( $meta_tags );

			foreach ( $meta_tags as $meta_tag ) {
				echo "$meta_tag\n";
			}

		}

	}
}
add_action( 'wp_head', 'cryptex_wp_site_icon', 99 );

/* 	Regex
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_regex') ) {

	/*
	*	Regex for url: http://mathiasbynens.be/demo/url-regex
	*/
	function cryptex_regex($string, $pattern = false, $start = "^", $end = "") {
		if (!$pattern) return false;

		if ($pattern == "url") {
			$pattern = "!$start((https?|ftp)://(-\.)?([^\s/?\.#-]+\.?)+(/[^\s]*)?)$end!";
		} else if ($pattern == "link") {
			$pattern = '/(((http|ftp|https):\/{2})+(([0-9a-z_-]+\.)+(aero|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel|ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cu|cv|cx|cy|cz|cz|de|dj|dk|dm|do|dz|ec|ee|eg|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mn|mn|mo|mp|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|nom|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ra|rs|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw|arpa)(:[0-9]+)?((\/([~0-9a-zA-Z\#\+\%@\.\/_-]+))?(\?[0-9a-zA-Z\+\%@\/&\[\];=_-]+)?)?))\b/imuS';
		} else if ($pattern == "mail") {
			$pattern = "!$start\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$end!";
		} else if ($pattern == "image") {
			$pattern = "!$start(https?(?://([^/?#]*))?([^?#]*?\.(?:jpg|gif|png)))$end!";
		} else if ($pattern == "mp4") {
			$pattern = "!$start(https?(?://([^/?#]*))?([^?#]*?\.(?:mp4)))$end!";
		} else if (strpos($pattern,"<") === 0) {
			$pattern = str_replace('<',"",$pattern);
			$pattern = str_replace('>',"",$pattern);

			if (strpos($pattern,"/") !== 0) { $close = "\/>"; $pattern = str_replace('/',"",$pattern); }
			$pattern = trim($pattern);
			if (!isset($close)) $close = "<\/".$pattern.">";

			$pattern = "!$start\<$pattern.+?$close!";
		}

		preg_match($pattern, $string, $result);

		if ( empty($result[0]) ) {
			return false;
		} else {
			return $result;
		}
	}
}

/*	Tag Archive Page
/* ---------------------------------------------------------------------- */

if (!function_exists('cryptex_tag_archive_page')) {

	function cryptex_tag_archive_page($query) {
		$post_types = get_post_types();
		global $cryptex_settings;

		if ( is_category() || is_tag() ) {
			if ( !is_admin() && $query->is_main_query() ) {

				$post_type = get_query_var(get_post_type());

				if ($post_type) {
					$post_type = $post_type;
				} else {
					$post_type = $post_types;
				}
				$query->set('post_type', $post_type);
			}
		}

		if ( $query->is_main_query() ) {

			if ( $query->is_post_type_archive('testimonials') ) {
				$query->query_vars['posts_per_page'] = $cryptex_settings['testimonials-archive-count'];
			} elseif ( $query->is_post_type_archive('team-members') ) {
				$query->query_vars['posts_per_page'] = $cryptex_settings['team-members-archive-count'];
			}

		}

		return $query;
	}
	add_filter('pre_get_posts', 'cryptex_tag_archive_page');
}

/* 	Filter Hook for Comments
/* --------------------------------------------------------------------- */

if ( !function_exists('cryptex_output_comments') ) {

	function cryptex_output_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>

		<li class="comment" id="comment-<?php echo comment_ID() ?>">

			<article>

				<!-- - - - - - - - - - - - - - Avatar - - - - - - - - - - - - - - - - -->

				<div class="gravatar">
					<?php echo get_avatar( $comment, 84, '', esc_html(get_comment_author()) ); ?>
				</div>

				<!-- - - - - - - - - - - - - - End of avatar - - - - - - - - - - - - - - - - -->

				<!-- - - - - - - - - - - - - - Comment body - - - - - - - - - - - - - - - - -->

				<div class="comment-body">

					<header class="comment-meta">

						<?php
						$author = '<h6 class="comment-author">'. get_comment_author() .'</h6>';
						$link = get_comment_author_url();
						if ( !empty($link) ) {
							$author = '<h6 class="comment-author"><a href="' . esc_url($link) . '">' . $author . '</a></h6>';
						}
						echo sprintf( '%s', $author );
						?>

						<div class="comment-info">
							<div class="entry-meta">

								<?php
								echo sprintf( '<time class="entry-date" datetime="%1$s">%2$s</time>',
									esc_attr( get_the_date( 'c' ) ),
									esc_attr( get_the_date( 'F j, Y, h:i A' ) )
								);
								?>

								<?php
								echo get_comment_reply_link(array_merge(
									array( 'reply_text' => esc_html__('Reply', 'cryptox') ),
									array( 'depth' => $depth, 'max_depth' => $args['max_depth'] )
								));
								?>

							</div><!--/ .entry-meta-->
						</div><!--/ .comment-info-->

					</header><!--/ .comment-meta-->

					<?php comment_text(); ?>

				</div><!--/ .comment-body-->

				<!-- - - - - - - - - - - - - - End of comment body - - - - - - - - - - - - - - - - -->

			</article>

		</li>

		<?php
	}
}

/* 	Filter Hooks for Respond
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_comments_form_hook')) {

	function cryptex_comments_form_hook ($defaults) {

		$commenter = wp_get_current_commenter();

		$req      = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$html_req = ( $req ? " required='required'" : '' );
		$required_text = sprintf( ' ' . esc_html__('Required fields are marked %s', 'cryptox'), esc_html__('(required)', 'cryptox') );

		$defaults['fields']['author'] = '<p class="comment-form-author"><input id="author" name="author" placeholder="' . esc_attr__( 'Name', 'cryptox' ) . ( $req ? '*' : '' ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' /></p>';

		$defaults['fields']['email'] = '<p class="comment-form-email"><input id="email" name="email" placeholder="' . esc_attr__( 'Email', 'cryptox' ) . ( $req ? '*' : '' ) . '" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p><div class="clear"></div>';

		$defaults['fields']['url'] = '<p class="comment-form-url"><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'cryptox' ) . '" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>';

		$defaults['comment_notes_before'] = '<p class="comment-notes"><span id="email-notes">' . esc_html__( 'Your email address will not be published.', 'cryptox' ) . '</span>'. ( $req ? $required_text : '' ) . '</p>';

		$defaults['comment_field'] = '<p class="comment-form-comment"><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'cryptox' ) . ' ' . ( $req ? '*' : '' ) . '" rows="4" aria-describedby="form-allowed-tags" aria-required="true" required="required"></textarea></p>';

		$defaults['cancel_reply_link'] = ' - ' . esc_html__('Cancel reply', 'cryptox');
		$defaults['class_submit'] = '';
		$defaults['label_submit'] = esc_html__( 'Submit Comment', 'cryptox' );
		$defaults['submit_field'] = '<p class="form-submit">%1$s %2$s</p>';

		return $defaults;
	}

	add_filter( 'comment_form_defaults', 'cryptex_comments_form_hook' );

}

if ( !function_exists('cryptex_comments_form_fields') ) {

	function cryptex_comments_form_fields($comment_fields) {
		$a = $comment_fields;
		$a = array_reverse($a);
		$b = array_pop($a);
		$a = array_reverse($a);
		$a['comment'] = $b;

		return $a;
	}

	add_filter('comment_form_fields', 'cryptex_comments_form_fields');

}

/*	Array to data string
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_create_data_string') ) {
	function cryptex_create_data_string($data = array()) {
		$data_string = "";

		if ( empty($data) ) return;

		foreach ( $data as $key => $value ) {
			if ( is_array($value) ) $value = implode(", ", $value);
			$data_string .= " data-$key='$value' ";
		}
		return $data_string;
	}
}

/*	Inline CSS
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_inline_css') ) {

	function cryptex_inline_css() {
		$post_id = cryptex_post_id();

		$content_padding = array();
		$body_bg_color = get_post_meta( $post_id, 'cryptex_body_bg_color', true );
		$image = get_post_meta( $post_id, 'cryptex_bg_image', true );
		$footer_bg_color = get_post_meta( $post_id, 'cryptex_footer_bg_color', true );

		if ( !empty($image) && $image > 0 ) {

			$image = array_shift($image);

			if ( isset($image['ID']) ) {
				$image = wp_get_attachment_image_src($image['ID'], '');

				if ( is_array($image) && isset($image[0]) ) {
					$image = $image[0];
				}

			}

		}

		$image_repeat     = get_post_meta( $post_id, 'cryptex_bg_image_repeat', true );
		$image_position   = get_post_meta( $post_id, 'cryptex_bg_image_position', true );
		$image_attachment = get_post_meta( $post_id, 'cryptex_bg_image_attachment', true );

		$page_content_padding = array();

		if ( $post_id )
			$content_padding = get_post_meta( $post_id, 'cryptex_page_content_padding', true );
		if ( $content_padding && is_array($content_padding) ) {
			$page_content_padding = array_filter( $content_padding, 'is_numeric' );
		}

		$css = $body_css = $footer_css = $inline_css = array();

		if ( !empty( $body_bg_color ) ) { $body_css[] = "background-color: $body_bg_color;"; }
		if ( !empty( $footer_bg_color ) ) { $footer_css[] = "background-color: $footer_bg_color;"; }

		if ( get_post_meta( $post_id, 'cryptex_footer_hidden_bg_image', true ) ) {
			$footer_css[] = "background-image: none !important;";
		}

		if ( !empty( $image ) && $image != 'none') { $body_css[] = "background-image: url('$image');"; }

		if ( !empty( $page_content_padding ) && is_array($page_content_padding) ) {
			if ( isset($page_content_padding[0]) ) {
				$padding_top = absint($page_content_padding[0]) . 'px';
				$inline_css[] = "padding-top: $padding_top;";
			}

			if ( isset($page_content_padding[1]) ) {
				$padding_bottom = absint($page_content_padding[1]) . 'px';
				$inline_css[] = "padding-bottom: $padding_bottom;";
			}
		}

		if ( !empty( $image ) && !empty( $image_attachment ) ) { $body_css[] = "background-attachment: $image_attachment;"; }
		if ( !empty( $image ) && !empty( $image_position ) )   { $body_css[] = "background-position: $image_position;"; }
		if ( !empty( $image ) && !empty( $image_repeat ) )     { $body_css[] = "background-repeat: $image_repeat;"; }

		?>
		<style type="text/css">
			<?php if ( $body_css ): ?>
				body { <?php echo implode( ' ', $body_css ) ?> }
			<?php endif; ?>

			<?php if ( $footer_css ): ?>
				#footer[class*="footer"] { <?php echo implode( ' ', $footer_css ) ?> }
			<?php endif; ?>

			<?php if ( $inline_css ): ?>
				.page-content-wrap { <?php echo implode( ' ', $inline_css ) ?>}
			<?php endif; ?>
		</style>

		<?php
	}

	add_filter('wp_head', 'cryptex_inline_css');
}

/*	Title
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_page_title') ) {

	function cryptex_page_title($args = false, $id = false ) {

		if ( empty($id) ) $id = cryptex_post_id();

		$defaults = array(
			'title' 	  => get_the_title($id),
			'subtitle'    => "",
			'output_html' => "<{heading} {attributes} class='page-title {class}'>{title}</{heading}>{additions}",
			'attributes'  => '',
			'class'		  => '',
			'heading'	  => 'h1',
			'additions'	  => ""
		);

		$args = wp_parse_args($args, $defaults);
		extract( $args, EXTR_SKIP );

		if ( !empty($subtitle) ) {
			$class .= ' with-subtitle';
			$additions .= "<div class='title-meta'>" . do_shortcode(wpautop($subtitle)) . "</div>";
		}

		$output_html = str_replace('{class}', $class, $output_html);
		$output_html = str_replace('{attributes}', $attributes, $output_html);
		$output_html = str_replace('{heading}', $heading, $output_html);
		$output_html = str_replace('{title}', $title, $output_html);
		$output_html = str_replace('{additions}', $additions, $output_html);
		return $output_html;
	}
}

/*	Which Archive
/* ---------------------------------------------------------------------- */

if ( !function_exists('cryptex_which_archive') ) {

	function cryptex_which_archive() {

		ob_start(); ?>

		<?php if ( is_category() ): ?>

			<?php echo esc_html__('Archive for Category:', 'cryptox') . " " . single_cat_title('', false); ?>

		<?php elseif ( is_day() ): ?>

			<?php echo esc_html__('Daily Archives:', 'cryptox') . " " . get_the_time( esc_html__('F jS, Y', 'cryptox')); ?>

		<?php elseif ( is_month() ): ?>

			<?php echo esc_html__('Monthly Archives:', 'cryptox') . " " . get_the_time( esc_html__('F, Y', 'cryptox')); ?>

		<?php elseif ( is_year() ): ?>

			<?php echo esc_html__('Yearly Archives:', 'cryptox') . " " . get_the_time( esc_html__('Y', 'cryptox')); ?>

		<?php elseif ( is_search() ): global $wp_query; ?>

			<?php if ( !empty($wp_query->found_posts) ): ?>

				<?php if ( $wp_query->found_posts > 1 ): ?>

					<?php echo esc_html__('Search results for:', 'cryptox')." " . esc_attr(get_search_query()) . " (". $wp_query->found_posts .")"; ?>

				<?php else: ?>

					<?php echo esc_html__('Search result for:', 'cryptox')." " . esc_attr(get_search_query()) . " (". $wp_query->found_posts .")"; ?>

				<?php endif; ?>

			<?php else: ?>

				<?php if ( !empty($_GET['s']) ): ?>

					<?php echo esc_html__('Search results for:', 'cryptox') . " " . esc_attr(get_search_query()); ?>

				<?php else: ?>

					<?php echo esc_html__('To search the site please enter a valid term', 'cryptox'); ?>

				<?php endif; ?>

			<?php endif; ?>

		<?php elseif ( is_author() ): ?>

			<?php $auth = ( get_query_var('author_name') ) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author')); ?>

			<?php if ( isset($auth->nickname) && isset($auth->ID) ): ?>

				<?php $name = $auth->nickname; ?>

				<?php echo esc_html__('Author Archive', 'cryptox'); ?>
				<?php echo esc_html__('for:', 'cryptox') . " " . $name; ?>

			<?php endif; ?>

		<?php elseif ( is_tag() ): ?>

			<?php echo esc_html__('Posts tagged &ldquo;', 'cryptox') . " " . single_tag_title('', false) . '&rdquo;'; ?>

			<?php
			$term_description = term_description();
			if ( ! empty( $term_description ) ) {
				printf( '<div class="taxonomy-description">%s</div>', $term_description );
			}
			?>

		<?php elseif ( is_tax() ): ?>

			<?php $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy')); ?>

			<?php echo esc_html__('Archive for:', 'cryptox') . " " . $term->name; ?>

		<?php else: ?>

			<?php if ( is_post_type_archive() ): ?>
				<?php echo sprintf(__('Archive %s', 'cryptox'), get_query_var('post_type')); ?>
			<?php else: ?>
				<?php echo esc_html__('Archive', 'cryptox'); ?>
			<?php endif; ?>

		<?php endif; ?>

		<?php return ob_get_clean();
	}
}

if ( !function_exists('cryptex_breadcrumbs') ) {

	function cryptex_breadcrumbs($args = array() ) {
		global $wp_query, $wp_rewrite;

		$trail = array();
		$path = '';
		$breadcrumb = '';

		$defaults = array(
			'after' => false,
			'separator' => '/',
			'front_page' => true,
			'show_home' => esc_html__( 'Home', 'cryptox' ),
			'show_posts_page' => true,
			'truncate' => 80
		);

		if (is_singular()) {
			$defaults["singular_{$wp_query->post->post_type}_taxonomy"] = false;
		}
		extract( wp_parse_args( $args, $defaults ) );

		if (!is_front_page() && $show_home) {
			$trail[] = '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . $show_home . '</a>';
		}

		if (is_front_page()) {
			if (!$front_page) {
				$trail = false;
			} elseif ($show_home) {
				$trail['end'] = "{$show_home}";
			}
		} elseif (is_home()) {
			$home_page = get_page( $wp_query->get_queried_object_id() );
			$trail = array_merge( $trail, cryptex_breadcrumbs_get_parents( $home_page->post_parent, '' ) );
			$trail['end'] = get_the_title( $home_page->ID );
		} elseif (is_singular()) {
			$post = $wp_query->get_queried_object();
			$post_id = absint( $wp_query->get_queried_object_id() );
			$post_type = $post->post_type;
			$parent = $post->post_parent;

			if ('page' !== $post_type && 'post' !== $post_type) {
				$post_type_object = get_post_type_object( $post_type );

				if (!empty( $post_type_object->rewrite['slug'] ) ) {
					$path .= $post_type_object->rewrite['slug'];
				}
				if (!empty($path)) {
					$trail = array_merge( $trail, cryptex_breadcrumbs_get_parents( '', $path ) );
				}
				if (!empty( $post_type_object->has_archive) && function_exists( 'get_post_type_archive_link' ) ) {
					$trail[] = '<a href="' . esc_url( get_post_type_archive_link( $post_type ) ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . $post_type_object->labels->name . '</a>';
				}
			}

			if (empty($path) && 0 !== $parent || 'attachment' == $post_type) {
				$trail = array_merge($trail, cryptex_breadcrumbs_get_parents($parent, ''));
			}

			if ( 'post' == $post_type && $show_posts_page == true && 'page' == get_option('show_on_front')) {
				$posts_page = get_option('page_for_posts');
				if ($posts_page != '' && is_numeric($posts_page)) {
					$trail = array_merge( $trail, cryptex_breadcrumbs_get_parents($posts_page, '' ));
				}
			}

			if ('post' == $post_type) {
				$category = get_the_category();

				foreach ($category as $cat)  {
					if (!empty($cat->parent))  {
						$parents = get_category_parents($cat->cat_ID, TRUE, '$$$', FALSE);
						$parents = explode("$$$", $parents);
						foreach ($parents as $parent_item) {
							if ($parent_item) $trail[] = $parent_item;
						}
						break;
					}
				}

				if (isset($category[0]) && empty($parents)) {
					$trail[] = '<a href="'. esc_url(get_category_link($category[0]->term_id )) .'">'.$category[0]->cat_name.'</a>';
				}

			}

			if (isset( $args["singular_{$post_type}_taxonomy"]) && $terms = get_the_term_list( $post_id, $args["singular_{$post_type}_taxonomy"], '', ', ', '' ) ) {
				$trail[] = $terms;
			}

			$post_title = get_the_title($post_id);

			if (!empty($post_title)) {
				$trail['end'] = $post_title;
			}

		} elseif (is_archive()) {

			if (is_tax() || is_category() || is_tag()) {
				$term = $wp_query->get_queried_object();
				$taxonomy = get_taxonomy( $term->taxonomy );

				if ( is_category() ) {
					$path = get_option( 'category_base' );
				} elseif ( is_tag() ) {
					$path = get_option( 'tag_base' );
				} else {
					if ($taxonomy->rewrite['with_front'] && $wp_rewrite->front) {
						$path = trailingslashit($wp_rewrite->front);
					}
					$path .= $taxonomy->rewrite['slug'];
				}

				if ($path) {
					$trail = array_merge($trail, cryptex_breadcrumbs_get_parents( '', $path ));
				}

				if (is_taxonomy_hierarchical($term->taxonomy) && $term->parent) {
					$trail = array_merge($trail, cryptex_get_term_parents( $term->parent, $term->taxonomy ) );
				}

				$trail['end'] = $term->name;

			} elseif (function_exists( 'is_post_type_archive' ) && is_post_type_archive()) {

				$post_type_object = get_post_type_object(get_query_var('post_type'));

				if (!empty($post_type_object->rewrite['archive'])) {
					$path .= $post_type_object->rewrite['archive'];
				}

				if (!empty($path)) {
					$trail = array_merge( $trail, cryptex_breadcrumbs_get_parents( '', $path ));
				}

				$trail['end'] = $post_type_object->labels->name;

			} elseif (is_author()) {
				if (!empty($wp_rewrite->front)) {
					$path .= trailingslashit($wp_rewrite->front);
				}
				if (!empty($wp_rewrite->author_base)) {
					$path .= $wp_rewrite->author_base;
				}
				if (!empty($path)) {
					$trail = array_merge( $trail, cryptex_breadcrumbs_get_parents( '', $path ));
				}
				$trail['end'] =  apply_filters('cryptex_author_name', get_the_author_meta('display_name', get_query_var('author')), get_query_var('author'));
			} elseif ( is_time()) {
				if (get_query_var( 'minute' ) && get_query_var('hour')) {
					$trail['end'] = get_the_time( esc_html__('g:i a', 'cryptox' ));
				} elseif ( get_query_var( 'minute' ) ) {
					$trail['end'] = sprintf( esc_html__('Minute %1$s', 'cryptox' ), get_the_time( esc_html__( 'i', 'cryptox' ) ) );
				} elseif ( get_query_var( 'hour' ) ) {
					$trail['end'] = get_the_time( esc_html__( 'g a', 'cryptox'));
				}
			} elseif (is_date()) {

				if ($wp_rewrite->front) {
					$trail = array_merge($trail, cryptex_breadcrumbs_get_parents('', $wp_rewrite->front));
				}

				if (is_day()) {
					$trail[] = '<a href="' . esc_url(get_year_link( get_the_time( 'Y' ) )) . '" title="' . get_the_time( esc_attr__( 'Y', 'cryptox' ) ) . '">' . get_the_time( esc_html__( 'Y', 'cryptox' ) ) . '</a>';
					$trail[] = '<a href="' . esc_url(get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) )) . '" title="' . get_the_time( esc_attr__( 'F', 'cryptox' ) ) . '">' . get_the_time( esc_html__( 'F', 'cryptox' ) ) . '</a>';
					$trail['end'] = get_the_time( esc_html__( 'j', 'cryptox' ) );
				} elseif ( get_query_var( 'w' ) ) {
					$trail[] = '<a href="' . esc_url(get_year_link( get_the_time( 'Y' ) )) . '" title="' . get_the_time( esc_attr__( 'Y', 'cryptox' ) ) . '">' . get_the_time( esc_html__( 'Y', 'cryptox' ) ) . '</a>';
					$trail['end'] = sprintf( esc_html__( 'Week %1$s', 'cryptox' ), get_the_time( esc_attr__( 'W', 'cryptox' ) ) );
				} elseif ( is_month() ) {
					$trail[] = '<a href="' . esc_url(get_year_link( get_the_time( 'Y' ) )) . '" title="' . get_the_time( esc_attr__( 'Y', 'cryptox' ) ) . '">' . get_the_time( esc_html__( 'Y', 'cryptox' ) ) . '</a>';
					$trail['end'] = get_the_time( esc_html__( 'F', 'cryptox' ) );
				} elseif ( is_year() ) {
					$trail['end'] = get_the_time( esc_html__( 'Y', 'cryptox' ) );
				}
			}
		} elseif ( is_search() ) {
			$trail['end'] = sprintf( esc_html__( 'Search results for &quot;%1$s&quot;', 'cryptox' ), esc_attr( get_search_query() ) );
		} elseif ( is_404() ) {
			$trail['end'] = esc_html__( '404 Not Found', 'cryptox' );
		}

		if (is_array($trail)) {
			if (!empty($trail['end'])) {
				if (!is_search()) {
					$trail['end'] = $trail['end'];
				}
				$trail['end'] = '<span class="trail-end">' . $trail['end'] . '</span>';
			}
			if (!empty($separator)) {
				$separator = '<span class="separate">'. $separator .'</span>';
			}
			$breadcrumb = join(" {$separator} ", $trail);

			if (!empty($after)) {
				$breadcrumb .= ' <span class="breadcrumb-after">' . $after . '</span>';
			}
		}
		return '<ul class="breadcrumbs">' . $breadcrumb . '</ul>';
	}
}

if (!function_exists('cryptex_breadcrumbs_get_parents')) {

	function cryptex_breadcrumbs_get_parents($post_id = '', $path = '') {
		$trail = array();

		if (empty($post_id) && empty($path)) {
			return $trail;
		}

		if (empty($post_id)) {
			$parent_page = get_page_by_path($path);

			if (empty($parent_page)) {
				$parent_page = get_page_by_title($path);
			}
			if (empty($parent_page)) {
				$parent_page = get_page_by_title (str_replace( array('-', '_'), ' ', $path));
			}
			if (!empty($parent_page)) {
				$post_id = $parent_page->ID;
			}
		}

		if ($post_id == 0 && !empty($path )) {
			$path = trim( $path, '/' );
			preg_match_all( "/\/.*?\z/", $path, $matches );

			if ( isset( $matches ) ) {
				$matches = array_reverse( $matches );
				foreach ( $matches as $match ) {

					if ( isset( $match[0] ) ) {
						$path = str_replace( $match[0], '', $path );
						$parent_page = get_page_by_path( trim( $path, '/' ) );

						if ( !empty( $parent_page ) && $parent_page->ID > 0 ) {
							$post_id = $parent_page->ID;
							break;
						}
					}
				}
			}
		}

		while ( $post_id ) {
			$page = get_page($post_id);
			$parents[]  = '<a href="' . esc_url(get_permalink( $post_id )) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . get_the_title( $post_id ) . '</a>';
			if(is_object($page)) {
				$post_id = $page->post_parent;
			} else {
				$post_id = "";
			}
		}
		if (isset($parents)) {
			$trail = array_reverse($parents);
		}
		return $trail;
	}

}

if (!function_exists('cryptex_get_term_parents')) {

	function cryptex_get_term_parents($parent_id = '', $taxonomy = '') {
		$trail = array();
		$parents = array();

		if (empty( $parent_id ) || empty($taxonomy)) {
			return $trail;
		}
		while ($parent_id) {
			$parent = get_term( $parent_id, $taxonomy );
			$parents[] = '<a href="' . esc_url(get_term_link( $parent, $taxonomy )) . '" title="' . esc_attr($parent->name) . '">' . $parent->name . '</a>';
			$parent_id = $parent->parent;
		}
		if (!empty($parents)) {
			$trail = array_reverse($parents);
		}
		return $trail;
	}

}

if( ! function_exists ('cryptex_get_taxonomy_terms') ) {
	function cryptex_get_taxonomy_terms($post_id, $taxonomy, $args = array() ) {

		$defaults = array(
			'type' => '',
			'list_class' => 'kw-agent-skills-list'
		);

		$args = wp_parse_args ( $args, $defaults );

		$terms = get_the_terms( $post_id, $taxonomy );

		if ( ! empty ( $terms ) ) {
			$out = array();

			if ( $args['type'] == 'list' ) {
				$out[] = '<ul class="' . sanitize_html_class($args['list_class']) . '">';
			}

			foreach ( $terms as $term ) {

				if ( $args['type'] == 'list' ) {
					$out[] = sprintf( '<li>%s</li>',
						sanitize_term_field( 'name', $term->name, $term->term_id, $taxonomy, 'display' )
					);
				} else {
					$out[] = sprintf( '%s',
						sanitize_term_field( 'name', $term->name, $term->term_id, $taxonomy, 'display' )
					);
				}

			}

			if ( $args['type'] == 'list' ) {
				$out[] = '</ul>';
			}

			return implode( ' ', $out );
		}

		return false;
	}
}

if ( !function_exists('cryptex_social_popup') ) {

	function cryptex_social_popup() {

		if ( empty($_POST['id']) ) return;

		if ( function_exists('cryptex_social_share_popup') ) {
			echo cryptex_social_share_popup( $_POST['id'] );
		}

		wp_die();
	}

	add_action( 'wp_ajax_cryptex_social_popup', 'cryptex_social_popup' );
	add_action( 'wp_ajax_nopriv_cryptex_social_popup', 'cryptex_social_popup' );

}

function cryptex_add_meta_field_cat () { ?>
	<div class="form-field">
		<label for="term_columns"><?php echo esc_html__('Columns', 'cryptox') ?></label>
		<select name="term_columns">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
		</select>
	</div>
	<div class="form-field">
		<label for="term_layout"><?php echo esc_html__('Layout', 'cryptox') ?></label>
		<select name="term_layout">
			<option value="entry-small"><?php echo esc_html__('Grid', 'cryptox') ?></option>
			<option value="list-type"><?php echo esc_html__('List', 'cryptox') ?></option>
		</select>
	</div>
	<div class="form-field">
		<label for="term_with_border"><?php echo esc_html__('Border', 'cryptox') ?></label>
		<select name="term_with_border">
			<option value="1"><?php echo esc_html__('Yes', 'cryptox') ?></option>
			<option value="0"><?php echo esc_html__('No', 'cryptox') ?></option>
		</select>
	</div>
	<?php
}

function cryptex_edit_meta_field_cat ( $term ) {
	if ( isset( $term->term_id ) ) {
		$current_columns = get_term_meta( $term->term_id, 'pix_term_columns', true );
		$current_layout = get_term_meta( $term->term_id, 'pix_term_layout', true );
		$current_border = get_term_meta( $term->term_id, 'pix_term_with_border', true );
	}
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="term_columns"><?php echo esc_html__('Columns', 'cryptox') ?></label></th>
		<td>
			<p>
				<select name="term_columns">
					<option <?php selected( $current_columns, 1 ) ?> value="1">1</option>
					<option <?php selected( $current_columns, 2 ) ?> value="2">2</option>
					<option <?php selected( $current_columns, 3 ) ?> value="3">3</option>
					<option <?php selected( $current_columns, 4 ) ?> value="4">4</option>
				</select>
			</p>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="term_layout"><?php echo esc_html__('Layout', 'cryptox') ?></label></th>
		<td>
			<p>
				<select name="term_layout">
					<option <?php selected( $current_layout, 'entry-small' ) ?> value="entry-small"><?php echo esc_html__('Grid', 'cryptox') ?></option>
					<option <?php selected( $current_layout, 'list-type' ) ?> value="list-type"><?php echo esc_html__('List', 'cryptox') ?></option>
				</select>
			</p>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="term_with_border"><?php echo esc_html__('Border', 'cryptox') ?></label></th>
		<td>
			<p>
				<select name="term_with_border">
					<option <?php selected( $current_go, '1' ) ?> value="1"><?php echo esc_html__('Yes', 'cryptox') ?></option>
					<option <?php selected( $current_layout, '0' ) ?> value="0"><?php echo esc_html__('No', 'cryptox') ?></option>
				</select>
			</p>
		</td>
	</tr>
	<?php
}

function cryptex_save_taxonomy_custom_meta ( $term_id ) {

	if ( isset( $_POST['term_columns'] ) ) {
		$value = $_POST['term_columns'];
		$current_value = get_term_meta( $term_id, 'pix_term_columns', true );

		if ( empty( $current_value ) ) {
			update_term_meta( $term_id, 'pix_term_columns', $value );
		} else {
			update_term_meta( $term_id, 'pix_term_columns', $value, $current_value );
		}
	}

	if ( isset( $_POST['term_layout'] ) ) {
		$value = $_POST['term_layout'];
		$current_value = get_term_meta( $term_id, 'pix_term_layout', true );

		if ( empty( $current_value ) ) {
			update_term_meta( $term_id, 'pix_term_layout', $value );
		} else {
			update_term_meta( $term_id, 'pix_term_layout', $value, $current_value );
		}
	}

	if ( isset( $_POST['term_with_border'] ) ) {
		$value = $_POST['term_with_border'];
		$current_value = get_term_meta( $term_id, 'pix_term_with_border', true );

		if ( empty( $current_value ) ) {
			update_term_meta( $term_id, 'pix_term_with_border', $value );
		} else {
			update_term_meta( $term_id, 'pix_term_with_border', $value, $current_value );
		}
	}

	update_termmeta_cache( array( $term_id ) );

}

add_action( 'category_add_form_fields', 'cryptex_add_meta_field_cat', 30 );
add_action( 'category_edit_form_fields', 'cryptex_edit_meta_field_cat', 30 );
add_action( 'edited_category',  'cryptex_save_taxonomy_custom_meta', 30 );
add_action( 'create_category',  'cryptex_save_taxonomy_custom_meta', 30 );

if ( !function_exists('cryptex_tribe_single_related_events')) {
	function cryptex_tribe_single_related_events()
	{
		tribe_get_template_part('related-events');
	}
}

if ( !function_exists('cryptex_tribe_get_related_posts')) {
	function cryptex_tribe_get_related_posts( $count = 3, $post = false ) {
		$post_id = Tribe__Events__Main::postIdHelper( $post );
		$tags = wp_get_post_tags( $post_id, array( 'fields' => 'ids' ) );
		$categories = wp_get_object_terms(
				$post_id,
				Tribe__Events__Main::TAXONOMY, array( 'fields' => 'ids' )
		);
		if ( ! $tags && ! $categories ) {
			return;
		}
		$args = array(
			'posts_per_page' => $count,
			'post__not_in' => array( $post_id ),
			'eventDisplay' => 'list',
			'tax_query' => array( 'relation' => 'OR' ),
			'orderby' => 'rand',
		);
		if ( $tags ) {
			$args['tax_query'][] = array(
				'taxonomy' => 'post_tag',
				'field' => 'id',
				'terms' => $tags
			);
		}
		if ( $categories ) {
			$args['tax_query'][] = array(
				'taxonomy' => Tribe__Events__Main::TAXONOMY,
				'field'    => 'id',
				'terms'    => $categories,
			);
		}
		if ( $args ) {
			$posts = Tribe__Events__Query::getEvents( $args );
		} else {
			$posts = array();
		}

		return $posts;
	}
}

if ( !function_exists('cryptex_page_title_get_value') ) {

	function cryptex_page_title_get_value( $meta_key = false ) {
		$value = false;
		$page_title = get_post_meta( cryptex_post_id(), 'cryptex_page_title', true );

		if ( $meta_key ) {
			if ( isset($page_title[$meta_key]) ) {
				$value = $page_title[$meta_key];
			}
		}

		return $value;
	}

}

function t_print_r($data) {
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}