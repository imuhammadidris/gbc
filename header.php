<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>

	<!-- Basic Page Needs
	==================================================== -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!-- Mobile Specific Metas
	==================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>

</head>
<?php
global $cryptex_config;
$header_classes = $cryptex_config['header_classes'];
$header_style = $cryptex_config['header_style'];
$page_content_classes = $cryptex_config['page_content_classes']; ?>

<body <?php body_class(); ?>><?php wp_body_open(); ?>

<?php do_action('cryptex_body_append', get_the_ID()); ?>

<div id="wrapper" class="wrapper-container">

	<nav id="mobile-advanced" class="mobile-advanced"></nav>

	<?php do_action( 'cryptex_header_prepend' ); ?>

	<!-- - - - - - - - - - - - - - Header - - - - - - - - - - - - - - - - -->

	<header id="header" class="header <?php echo esc_attr($header_classes); ?>">
		<?php do_action( 'cryptex_header_layout', $header_style ); ?>
	</header><!--/ #header -->

	<!-- - - - - - - - - - - - - - / Header - - - - - - - - - - - - - - -->

	<?php
		/**
		 * cryptex_header_after hook
		 *
		 * @hooked page_title_and_breadcrumbs
		 */

		do_action( 'cryptex_header_after' );
	?>

	<div id="content" class="<?php echo sprintf( '%s', $page_content_classes ) ?>">

		<?php do_action( 'cryptex_page_content_prepend' ); ?>

		<div class="entry-content">

			<div class="container">

				<div class="row">

					<main id="main" class="site-main">