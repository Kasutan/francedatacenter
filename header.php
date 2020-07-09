<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package francedatacenter
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	
	<link rel="dns-prefetch" href="//fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>


	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main">Aller directement au contenu</a>
	<?php if (function_exists('get_field') && !empty(get_field('fdc_topbar','option'))) {
		printf('<div class="topbar">%s</div>',get_field('fdc_topbar','option'));
	} ?>
	
	<header id="masthead" class="site-header">

		<div class="site-branding">
			<?php
			if(has_custom_logo(  )) {
				the_custom_logo(  );
			} else {
				printf('<a href="%s" class="custom-logo"><img alt="My Big Bang" src="%s" width="286" height="55"/></a>',
					esc_url( home_url( '/' ) ),
					fdc_get_picto_url('Logo-MPP-Header')
				);
			}
			?>
		</div>

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="Menu">

				<svg version="1.1"class="menu"  xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px"
					viewBox="0 0 39 31" style="enable-background:new 0 0 39 31;">
				<g transform="translate(1.5 1.5)">
					<path fill="#EC6557" d="M36,1.5H0c-0.8,0-1.5-0.7-1.5-1.5S-0.8-1.5,0-1.5h36c0.8,0,1.5,0.7,1.5,1.5S36.8,1.5,36,1.5z"/>
					<path fill="#77736B" d="M36,16.1H0c-0.8,0-1.5-0.7-1.5-1.5c0-0.8,0.7-1.5,1.5-1.5h36c0.8,0,1.5,0.7,1.5,1.5
						C37.5,15.4,36.8,16.1,36,16.1z"/>
					<path  fill="#77736B" d="M36,29.5H0c-0.8,0-1.5-0.7-1.5-1.5s0.7-1.5,1.5-1.5h36c0.8,0,1.5,0.7,1.5,1.5S36.8,29.5,36,29.5z"/>
				</g>
				</svg>

				<svg version="1.1" class="times" xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px"
					viewBox="0 0 29.7 29.7" style="enable-background:new 0 0 29.7 29.7;" >
				<g  transform="translate(2.122 2.121)">
					<g transform="translate(0 0) rotate(45)">
						<path fill="#77736B" d="M37.1,1.1c-0.3,0.3-0.6,0.4-1.1,0.4H0c-0.8,0-1.5-0.7-1.5-1.5c0-0.8,0.7-1.5,1.5-1.5h36
							c0.8,0,1.5,0.7,1.5,1.5C37.5,0.4,37.3,0.8,37.1,1.1z"/>
					</g>
					<g  transform="translate(0 25.456) rotate(-45)">
						<path  fill="#EC6557" d="M-1.1,1.1C-1.3,0.8-1.5,0.4-1.5,0c0-0.8,0.7-1.5,1.5-1.5h36c0.8,0,1.5,0.7,1.5,1.5c0,0.8-0.7,1.5-1.5,1.5H0
							C-0.4,1.5-0.8,1.3-1.1,1.1z"/>
					</g>
				</g>
				</svg>
			</button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

