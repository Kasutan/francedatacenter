<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package francedatacenter
 */

get_header();
$term=get_queried_object(  );
?>

		<main id="main" class="site-main">
		<header class="entry-header decoupe-gauche">
			<?php
				
			if(function_exists('fdc_archive_thumbnail')) echo '<div class="image">'.fdc_archive_thumbnail('banniere',$term->term_id).'</div>';

			printf('<div class="texte-banniere"><h1 class="page-title"><span>Actualités</span><br>%s</h1></div>',get_the_archive_title());

			if(function_exists('fdc_get_picto_url')) printf('<a href="#entry-content"><img src="%s" alt="fleche vers le bas" width="40" height="23"/></a>',fdc_get_picto_url('angle-bas'));
			?>
		</header><!-- .entry-header -->
		<div class="entry-content container avec-ancre"><div class="ancre" id="entry-content"></div>
		<?php
		if ( function_exists( 'fdc_fil_ariane' ) )  fdc_fil_ariane();

		 if ( have_posts() ) : 

			echo '<ul class="actualites alignfull">';
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				if(function_exists('fdc_affiche_actualite')) fdc_affiche_actualite(get_the_ID(),'h2');
			endwhile;
			?>
			</ul>
			<?php
			
			if (function_exists('wp_pagenavi')) :
				wp_pagenavi();
			else :
				the_posts_navigation();
			endif;


		else :

			echo '<section class="no-results not-found">';
				echo'<p>Aucun article ne correspond à cette thématique. Voulez-vous essayer une recherche&nbsp;?</p>';
				
				get_search_form();
			echo '</section>';

		endif;
		echo '</div>';

		?>

		</main><!-- #main -->

<?php

get_footer();
