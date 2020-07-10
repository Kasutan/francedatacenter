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
	
	<header id="masthead" class="site-header">

		<div class="site-branding">
			<?php
			if(has_custom_logo(  )) {
				the_custom_logo(  );
			} else {
				printf('<a href="%s" class="custom-logo"><img alt="France Data Center" src="%s" width="244" height="89"/></a>',
					esc_url( home_url( '/' ) ),
					fdc_get_picto_url('logo')
				);
			}
			?>
		</div>

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="Menu">

				<svg xmlns="http://www.w3.org/2000/svg" class="menu" width="28.964" height="23.016" viewBox="0 0 28.964 23.016"><path d="M28.576,80.327H.388A.388.388,0,0,1,0,79.94V78.388A.388.388,0,0,1,.388,78H28.576a.388.388,0,0,1,.388.388V79.94A.388.388,0,0,1,28.576,80.327Zm0,10.344H.388A.388.388,0,0,1,0,90.284V88.732a.388.388,0,0,1,.388-.388H28.576a.388.388,0,0,1,.388.388v1.552A.388.388,0,0,1,28.576,90.672Zm0,10.344H.388A.388.388,0,0,1,0,100.628V99.076a.388.388,0,0,1,.388-.388H28.576a.388.388,0,0,1,.388.388v1.552A.388.388,0,0,1,28.576,101.016Z" transform="translate(0 -78)" fill="#37b0b0"/></svg>

				<svg xmlns="http://www.w3.org/2000/svg" class="times" width="22.627" height="23.023" viewBox="0 0 22.627 23.023"><g transform="translate(-322.82 -28.424)"><path d="M1.38.22H27.94" transform="translate(323.768 29.06) rotate(45)" fill="none" stroke="#37b0b0" stroke-linecap="round" stroke-width="2.5"/><path d="M1.38.22H27.94" transform="translate(344.811 30.078) rotate(135)" fill="none" stroke="#37b0b0" stroke-linecap="round" stroke-width="2.5"/></g></svg>

			</button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

