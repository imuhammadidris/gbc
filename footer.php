<?php global $cryptex_config; ?>

						</main><!--/ .site-main-->

					<?php get_sidebar(); ?>

				</div><!--/ .row-->

			</div><!--/ .container-->

		</div><!--/ .entry-content-->

	</div><!--/ #content-->

	<!-- - - - - - - - - - - - - - Footer - - - - - - - - - - - - - - - - -->

	<footer id="footer" class="footer">

		<?php
		/**
		 * cryptex_footer_append hook
		 *
		 */

		do_action('cryptex_footer_append');
		?>

	</footer><!--/ #footer-->

	<!-- - - - - - - - - - - - - -/ Footer - - - - - - - - - - - - - - - - -->

</div><!--/ #wrapper-->

<?php wp_footer(); ?>

</body>
</html>