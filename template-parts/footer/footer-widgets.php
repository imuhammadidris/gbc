<?php
global $cryptex_settings;
$result = Cryptex_Widgets_Meta_Box::get_page_settings( cryptex_post_id() );
extract( $result );
?>

<div class="main-footer">

	<div class="container">

		<?php if ( $footer_row_show ): ?>

			<div class="row">

				<?php if ( !empty($footer_row_columns_variations) ):
					$number_of_columns = key( json_decode( html_entity_decode ( $footer_row_columns_variations ), true ) );
					$columns_array = json_decode( html_entity_decode ( $footer_row_columns_variations ), true );
					?>

					<?php for ( $i = 1; $i <= $number_of_columns; $i++ ): ?>

						<div class="col-sm-<?php echo esc_attr($columns_array[$number_of_columns][0][$i-1]); ?>">

							<?php if ( is_active_sidebar($get_sidebars_widgets[$i-1]) ): ?>

								<?php dynamic_sidebar($get_sidebars_widgets[$i-1]); ?>

							<?php else:  ?>

								<?php cryptex_dummy_widget($i) ?>

							<?php endif; ?>

						</div>

					<?php endfor; ?>

				<?php endif; ?>

			</div><!--/ .row-->

		<?php endif; ?>

	</div><!--/ .container-->

</div><!--/ .main-footer-->
