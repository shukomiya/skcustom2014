<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
<?php $index_ad_count = 0; ?>
<script src="https://use.fontawesome.com/9b0c8d6824.js"></script>
<style type="text/css">.wpp-list li { padding: 5px 0; } </style>
</head>
<body <?php body_class(); ?>>
<?php sk_get_access_analy_google(); ?>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		<hgroup>
			<?php if ( is_mobile() ) : ?>
				<?php if ( !function_exists( "wprmenu_menu" ) ) :  ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php endif; ?>
			<?php else : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			<?php endif; ?>
		</hgroup>

		<?php if ( get_header_image() ) : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php if ( is_front_page() ) : ?><img src="<?php header_image(); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" /><?php endif; ?></a>
		<?php endif; ?>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></button>
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</nav><!-- #site-navigation -->
		<div class="breadcrumbs">
		    <?php 
		    	if ((!is_mobile()) && function_exists('bcn_display')) {
		        	bcn_display();
		    	}
		    ?>
		</div>
		<?php if ( sk_is_campaign_in( date('Y/m/d', time() ), '2017/06/30', '2017/07/11' ) ) : ?>
		<?php if ( is_mobile() ) { ?>
		<div style="margin-top: 48px;margin-bottom:12px;text-align: center; line-height: 1.5;">
		<iframe src="https://rcm-fe.amazon-adsystem.com/e/cm?o=9&p=294&l=ur1&category=primeday2017&banner=0EPS4JBBWAGBZGW08HG2&f=ifr&linkID=fa6dc84ea0e2541e7252d9277bce272a&t=missionmarket-22&tracking_id=missionmarket-22" width="320" height="100" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
		</div>
		<?php } else { ?>
		<div style="margin-top: 48px;margin-bottom:12px;text-align: center; line-height: 1.5;">
		<iframe src="https://rcm-fe.amazon-adsystem.com/e/cm?o=9&p=48&l=ur1&category=primeday2017&banner=006JNFEE1THEZRHFYT02&f=ifr&linkID=f1019db2c1c6cd6bcb08c3d4afa14879&t=missionmarket-22&tracking_id=missionmarket-22" width="728" height="90" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe></div>
			<?php } ?>
		<?php endif; ?>
	</header><!-- #masthead -->

	<div id="main" class="wrapper">