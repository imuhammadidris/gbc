<?php

$include_plugins = array(
	'category-icon'
);

foreach ( $include_plugins as $inc ) {
	require_once get_theme_file_path( "includes/plugins/{$inc}/init.php" );
}