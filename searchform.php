<form class="search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<button class="btn btn-style-4 icon-btn f-right" type="submit"><i class="licon-magnifier"></i></button>
	<div class="wrapper">
		<input type="text" autocomplete="off" id="s" name="s" placeholder="<?php esc_attr_e( 'Search', 'cryptox' ) ?>" value="<?php echo get_search_query(); ?>">
	</div>
</form>