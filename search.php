<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package francedatacenter
 */

get_header();
				//TODO afficher une image bannière -> image par défaut

?>

		<main id="main" class="site-main">


			<header class="entry-header"> 
			<?php 
				$defaut='';
				if(function_exists('get_field')) {
					$defaut=esc_attr(get_field('banniere_defaut','option'));
				} 
				if($defaut) {
					printf('<div class="image">%s</div>',
					wp_get_attachment_image( $defaut, 'banniere')
					);
				}
				echo '<div class="texte-banniere">';
					printf('<h1 class="page-title">Votre recherche&nbsp;:<br> %s</h1>',get_search_query());
				echo '</div>';
				if(function_exists('fdc_get_picto_url')) printf('<a href="#entry-content"><img src="%s" alt="fleche vers le bas" width="40" height="23"/></a>',fdc_get_picto_url('angle-bas'));
				?>
			</header><!-- .page-header -->
			<div class="entry-content container avec-ancre"><div class="ancre" id="entry-content"></div>
			<?php
			if ( function_exists( 'fdc_fil_ariane' ) )  fdc_fil_ariane();
			
			if ( have_posts() ) : 

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;
			

		else :

			echo '<section class="no-results not-found">';
			echo '<p>Désolé, aucun résultat n\'a été trouvé. Voulez-vous essayer avec des mots-clés différents&nbsp;?</p>';
				
			get_search_form();
		echo '</section>';

		endif;

		echo '</div>'; //fin entry-content
		
		?>

		</main><!-- #main -->

<?php
get_footer();
