<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Near_Perfection
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head();?>

</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'near_perfection' ); ?></a>

	<header id="masthead" class="site-header">
		
		<div class="site-branding">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img alt="<?php bloginfo( 'name' ); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/img/near-perfection-logo.svg" onerror="this.onerror=null; this.src='<?php bloginfo('stylesheet_directory'); ?>/img/near-perfection-logo@2x.png'"></a>
			<?php
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
			endif; ?>
		</div><!-- .site-branding -->

		<div id="socnetHeader">
			<a class="fa-facebook" href="https://www.facebook.com/mantairLtd" aria-label="mantair's facebook page" target="_blank"></a>
			<a class="fa-twitter" href="https://twitter.com/mantairLtd" aria-label="mantair's twitter page" target="_blank"></a>
		</div>

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-label="Navigation menu" aria-expanded="false"><?php esc_html_e( '', 'near_perfection' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
