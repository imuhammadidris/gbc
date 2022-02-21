<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->buildTemplate( $atts, $content );
$containerClass = trim( 'call-out ' . esc_attr( implode( ' ', $this->getTemplateVariable( 'container-class' ) ) ) );
$columnLeftClasses = esc_attr( implode( ' ', $this->getTemplateVariable( 'column-left-class' ) ) );
$columnRightClasses = esc_attr( implode( ' ', $this->getTemplateVariable( 'column-right-class' ) ) );
?>
<div class="<?php echo esc_attr( $containerClass ); ?>">

	<div class="container">

		<?php if ( $atts['align'] == 'align-center' ): ?>

			<div class="align-center">

				<div class="content-element3">
					<?php echo ' ' . $this->getTemplateVariable( 'heading' ); ?>
					<?php echo ' ' . $this->getTemplateVariable( 'subheading' ); ?>
				</div>

				<?php echo ' ' . $this->getTemplateVariable( 'actions-button' ); ?>

			</div>

		<?php elseif ( $atts['align'] == 'align-right' ): ?>

			<div class="row align-items-center">

				<div class="col-lg-8 col-md-12 offset-lg-5">
					<?php echo ' ' . $this->getTemplateVariable( 'heading' ); ?>
					<?php echo ' ' . $this->getTemplateVariable( 'subheading' ); ?>
					<?php echo ' ' .  $this->getTemplateVariable( 'actions-button' ); ?>
				</div>

			</div>

		<?php else: ?>

			<div class="row align-items-center">

				<div class="<?php echo esc_attr($columnLeftClasses)  ?>">
					<?php echo ' ' . $this->getTemplateVariable( 'heading' ); ?>
					<?php echo ' ' . $this->getTemplateVariable( 'subheading' ); ?>
				</div>

				<div class="<?php echo esc_attr($columnRightClasses)  ?>">
					<?php echo ' ' . $this->getTemplateVariable( 'actions-button' ); ?>
					<?php echo ' ' . $this->getTemplateVariable( 'actions-form' ); ?>
				</div>

			</div><!--/ .row-->

		<?php endif; ?>

	</div><!--/ .container-->

</div><!--/ .call-out-->
