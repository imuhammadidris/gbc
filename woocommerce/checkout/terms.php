<?php
/**
 * Checkout terms and conditions area.
 *
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( apply_filters( 'woocommerce_checkout_show_terms', true ) && function_exists( 'wc_terms_and_conditions_checkbox_enabled' ) ) :
	do_action( 'woocommerce_checkout_before_terms_and_conditions' );
	?>
	<div class="woocommerce-terms-and-conditions-wrapper">
		<?php
		/**
		 * Terms and conditions hook used to inject content.
		 *
		 * @since 3.4.0.
		 * @hooked wc_privacy_policy_text() Shows custom privacy policy text. Priority 20.
		 * @hooked wc_terms_and_conditions_page_content() Shows t&c page content. Priority 30.
		 */
		do_action( 'woocommerce_checkout_terms_and_conditions' );
		?>

		<?php if ( wc_terms_and_conditions_checkbox_enabled() ) : ?>
			<p class="form-row terms wc-terms-and-conditions">
				<div class="input-wrapper style-2">

					<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); ?> id="terms" />

					<label for="terms" class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
						<?php printf( __( 'I&rsquo;ve read and accept the <a href="%s" target="_blank" class="link-text woocommerce-terms-and-conditions-link">terms &amp; conditions</a>', 'cryptox' ), esc_url( wc_get_page_permalink( 'terms' ) ) ); ?>
						<span class="required">*</span>
					</label>
				</div>

				<input type="hidden" name="terms-field" value="1" />
			</p>
		<?php endif; ?>

	</div>

	<?php do_action( 'woocommerce_checkout_after_terms_and_conditions' ); ?>

<?php endif; ?>
