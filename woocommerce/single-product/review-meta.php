<?php
/**
 * The template to display the reviewers meta data (name, verified owner, review date)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review-meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $comment;
$verified = wc_review_is_from_verified_owner( $comment->comment_ID );

if ( '0' === $comment->comment_approved ) { ?>

	<p class="meta"><em class="woocommerce-review__awaiting-approval"><?php esc_attr_e( 'Your review is awaiting approval', 'cryptox' ); ?></em></p>

<?php } else { ?>

	<div class="comment-meta">

		<h6 class="comment-author">
			<span class="woocommerce-review__author"><?php comment_author(); ?></span> <?php

			if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
				echo '<em class="woocommerce-review__verified verified">(' . esc_attr__( 'verified owner', 'cryptox' ) . ')</em> ';
			}?>
		</h6>

		<div class="comment-info">

			<?php
			echo sprintf( '<time class="woocommerce-review__published-date" datetime="%1$s">%2$s</time>',
				esc_attr( get_comment_date( 'c' ) ),
				esc_attr( get_comment_date( 'D j, Y, h:i A' ) )
			);
			?>

			<?php
			global $comment;
			$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

			if ( $rating && 'yes' === get_option( 'woocommerce_enable_review_rating' ) ) {
				echo wc_get_rating_html( $rating );
			}
			?>

		</div>

	</div>

<?php }
