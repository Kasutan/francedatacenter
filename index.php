<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package francedatacenter
 */

get_header();
?>

		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) :?>

			<header class="entry-header decoupe-gauche">
				<?php
				
				if(function_exists('fdc_archive_thumbnail')) echo '<div class="image">'.fdc_archive_thumbnail('banniere').'</div>';

				printf('<div class="texte-banniere"><h1 class="page-title"><span>Actualités</span><br>Tous les articles</h1></div>');

				if(function_exists('fdc_get_picto_url')) printf('<a href="#entry-content"><img src="%s" alt="fleche vers le bas" width="40" height="23"/></a>',fdc_get_picto_url('angle-bas'));
				?>
			</header><!-- .entry-header -->
			<div class="entry-content container avec-ancre"><div class="ancre" id="entry-content"></div>
			<?php 
			if ( function_exists( 'fdc_fil_ariane' ) )  fdc_fil_ariane();

			echo '<ul class="actualites alignfull">';
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				if(function_exists('fdc_affiche_actualite')) fdc_affiche_actualite(get_the_ID(),'h2');
			endwhile;
			?>
			</ul>

			<?php if (function_exists('wp_pagenavi')) :
				wp_pagenavi();
			else :
				the_posts_navigation();
			endif;

			echo '</div>';

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->

<?php
get_footer();
