<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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
					wp_get_attachment_image( $defaut, $taille)
					);
				}
				echo '<div class="texte-banniere">';
					printf('<h1 class="page-title">Page introuvable</h1>');
				echo '</div>';
				if(function_exists('fdc_get_picto_url')) printf('<a href="#entry-content"><img src="%s" alt="fleche vers le bas" width="40" height="23"/></a>',fdc_get_picto_url('angle-bas'));
				?>
		</header><!-- .page-header -->
		<div class="entry-content container avec-ancre"><div class="ancre" id="entry-content"></div>
		<?php
		if ( function_exists( 'fdc_fil_ariane' ) )  fdc_fil_ariane();
			
			echo '<section class="no-results not-found">';
				echo '<p>Cette page n\'existe pas. Voulez-vous essayer une recherche&nbsp;?</p>';
				get_search_form();
			echo '</section>';
		echo '</div>'; //fin entry-content
		?>

	</main><!-- #main -->

<?php
get_footer();
