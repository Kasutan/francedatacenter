<?php
/**
 * The template for displaying all pages and posts
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package francedatacenter
 */

get_header();

?>

<main id="main" class="site-main">
<?php
	while ( have_posts() ) :
		the_post(); 

		if(function_exists('get_field')) {
			$baseline=wp_kses_post( get_field('baseline'));
			$decoupe_banniere=esc_html( get_field('decoupe_banniere'));
			$decor_banniere=esc_html( get_field('decor_banniere'));
		} else {
			$baseline=$decoupe_banniere=$decor_banniere='';
		}

		if(function_exists('fdc_get_page_ID') && fdc_get_page_ID('page_ressources')) {
			$ressources=fdc_get_page_ID('page_ressources');//ID stocké dans une option ACF
			$titre=get_the_title($ressources);
			$image=get_the_post_thumbnail($ressources, 'banniere');
			$url=get_the_permalink($ressources);
		} else {
			$titre=$image=$url='';
		}

		if(function_exists('fdc_get_picto_inline')) {
			$angle=fdc_get_picto_inline('angle');
		} else {
			$angle='';
		}
		

		printf('<header class="entry-header %s %s">',$decoupe_banniere,$decor_banniere);
			if($image) printf('<div class="image">%s</div>'); elseif(function_exists('fdc_post_thumbnail')) echo '<div class="image">'.fdc_post_thumbnail('banniere').'</div>';
			echo '<div class="texte-banniere">';
				if($titre) printf('<h1 class="page-title">%s</h1>',$titre); else printf('<h1 class="page-title">%s</h1>',get_the_title());
				if($baseline) printf('<p class="baseline">%s</p>',$baseline);
			echo '</div>';
			if(function_exists('fdc_get_picto_url')) printf('<a href="#entry-content"><img src="%s" alt="fleche vers le bas" width="40" height="23"/></a>',fdc_get_picto_url('angle-bas'));
			?>
		</header><!-- .entry-header -->


		<div class="entry-content container avec-ancre"><div class="ancre" id="entry-content"></div>
			<div class="overlay"></div>
			<?php 
				if ( function_exists( 'fdc_fil_ariane' ) )  fdc_fil_ariane();

				if ( function_exists( 'fdc_affiche_ressource' ) ) {
					echo '<ul class="liste-ressources">';
						fdc_affiche_ressource(get_the_ID());
					echo '</ul>';
				} else {
					the_content();
				}

				if($url) printf('<div class="fleche"><a href="%s"><span>Toutes les ressources</span>%s</a></div>', $url, $angle);

			?>

		</div><!-- .entry-content -->

		<?php	

endwhile; // End of the loop. ?>

</main><!-- #main -->

<?php
get_footer();
