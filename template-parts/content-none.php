<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package francedatacenter
 */

?>

<section class="no-results not-found">
	<header class="entry-header">
		<div class="texte-banniere"><h1 class="page-title">Aucun résultat</h1></div>
		<?php if(function_exists('fdc_get_picto_url')) printf('<a href="#entry-content"><img src="%s" alt="fleche vers le bas" width="40" height="23"/></a>',fdc_get_picto_url('angle-bas'));?>
	</header><!-- .page-header -->

	<div class="entry-content container" id="entry-content">
		<?php
		if ( is_search() ) :
			?>

			<p>Désolé, aucun résultat n'a été trouvé. Voulez-vous essayer avec des mots-clés différents&nbsp;?</p>
			<?php
			get_search_form();

		else :
			?>

			<p>Voulez-vous essayer une recherche&nbsp;?</p>
			<?php
			get_search_form();

		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
